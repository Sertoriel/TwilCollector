<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessageLog;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class MessageLogController extends Controller
{

    public function lookup(Request $request)
    {
        set_time_limit(300); // desabilita timeout para grandes listas (5 minutos)  
        if (!session('twilcred_authenticated')) {
            return redirect()->route('login');
        }
        //📚 Dados de Cred Twilio
        $sid = session('twilcred_sid');
        $token = session('twilcred_token');

        $client = new Client($sid, $token);

        // 📚 Validação dos dados recebidos
        $request->validate([
            'sids' => 'required|array',
            'sids.*' => 'required|string'
        ]);
        $sids = $request->input('sids');

        foreach ($sids as $sid) {
            try {
                $msg = $client->messages($sid)->fetch();

                $log = MessageLog::create([
                    'sid'           => $sid,
                    'status'        => $msg->status,
                    'error_code'    => $msg->errorCode ?? 0,
                    'body'          => $msg->body,
                    'error_message' => null,
                    'twilcred_settings_id' => session('twilcred_profile_id'),
                ]);
                                                                // // Isn't isset($msg->errorCode) because Twilio returns null if no error
                                                                //                 Log::info("Mensagem SID: {$sid} - Status: {$msg->status}");
                $results[] = $log;
            } catch (\Throwable $e) {
                $log = MessageLog::create([
                    'sid'           => $sid,
                    'status'        => 'erro',
                    'error_code'    => $e->getCode(),
                    'body'          => null,
                    'error_message' => $e->getMessage(),
                ]);

                $results[] = $log;
            }
        }

        return response()->json($results);
    }


    public function ReadFile(Request $request)
    {
         // Função 1: Processa arquivo TXT e retorna SIDs
        $request->validate([
            'sids_file' => 'required|file|mimes:txt'
        ]);

        if (!$request->file('sids_file')->isValid()) {
            return response()->json(['error' => 'Arquivo inválido'], 400);
        }

        $filePath = $request->file('sids_file')->getRealPath();
        $sids = collect(file($filePath))
            ->map(fn($line) => trim($line))
            ->filter()
            ->unique()
            ->values(); // Reindexa o array

        return response()->json(['sids' => $sids]);
    }

    public function GetHistory(Request $request)
    {
        if (!session('twilcred_authenticated')) {
            return redirect()->route('login');
        }

        $history = MessageLog::where('twilcred_settings_id', session('twilcred_profile_id'))
            ->orderBy('created_at', 'desc')
            ->paginate(30); // Paginação de 30 registros por página

        return view('messages.history', compact('history'));

    }
}
