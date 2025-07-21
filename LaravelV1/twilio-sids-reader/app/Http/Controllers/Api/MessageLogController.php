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
        $settings = \App\Models\Twilcred_Settings::first();

        //📚 Dados de Cred Twilio
        $client = new Client(
            $settings ? Crypt::decryptString($settings->account_sid) : config('twilio.account_sid'),
            $settings ? Crypt::decryptString($settings->auth_token) : config('twilio.auth_token')
        );

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
}
