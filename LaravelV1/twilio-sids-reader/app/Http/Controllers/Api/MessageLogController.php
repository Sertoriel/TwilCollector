<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessageLog;
use Twilio\Rest\Client;

class MessageLogController extends Controller
{
    public function lookup(Request $request)
    {
        set_time_limit(300); // desabilita timeout para grandes listas (5 minutos)  

        //📚 Dados de Cred Twilio
        $client = new Client(
            config('twilio.account_sid'),
            config('twilio.auth_token')
        );

        // 📚 Validação dos dados recebidos
        $request->validate([
            'sids' => 'required|array',
            'sids.*' => 'required|string'
            // 'sids_file' => 'nullable|file|mimes:txt',
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
    // if ($request->hasFile('sids_file') && !$request->file('sids_file')->isValid()) {
    //     Log::error('Erro ao carregar o arquivo de SIDs', [
    //         'file' => $request->file('sids_file')->getErrorMessage(),
    //     ]);
    // }

    // //📚 Extrair SIDs do arquivo OU do Texto, se fornecido

    // $sids = null;

    // if (!empty($request->input('sids'))) {
    //     $sids = collect($request->input('sids'))
    //         ->map(fn($sid) => trim($sid))
    //         ->filter()
    //         ->unique();
    // } elseif ($request->hasFile('sids_file')) {
    //     $fileLines = file($request->file('sids_file')->getRealPath());
    //     $sids = collect($fileLines)
    //         ->map(fn($line) => trim($line))
    //         ->filter()
    //         ->unique();
    // } else {
    //     return response()->json(['error' => 'Nenhum SID fornecido'], 400);
    // }

    // $results = [];
}
