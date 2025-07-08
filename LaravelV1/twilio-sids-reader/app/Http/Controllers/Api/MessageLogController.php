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
        set_time_limit(30); // desabilita timeout para grandes listas (5 minutos)  
        
        //📚 Dados de Cred Twilio
        $client = new Client(
            config('twilio.account_sid'),
            config('twilio.auth_token')
        );

        // 📚 Validação dos dados recebidos
        $request->validate([
            'sids' => 'nullable|array',
            'sids.*' => 'nullable|string',
            'sids_file' => 'nullable|file|mimes:txt',
        ]);
        if ($request->hasFile('sids_file') && !$request->file('sids_file')->isValid()) {
            Log::error('Erro ao carregar o arquivo de SIDs', [
                'file' => $request->file('sids_file')->getErrorMessage(),
            ]);
        }

        //📚 Extrair SIDs do arquivo OU do Texto, se fornecido

        if (!empty($request->sids)) {
            $request->sids = collect($request->sids)
                ->map(fn($sid) => trim($sid))
                ->filter() // remove vazios
                ->unique(); // evita duplicatas
        } elseif ($request->hasFile('sids_file')) {
            $fileLines = file($request->file('sids_file')->getRealPath());
            $request->sids = collect($fileLines)
                ->map(fn($line) => trim($line))
                ->filter()
                ->unique();
        } else {
            return response()->json(['error' => 'Nenhum SID fornecido'], 400);
        }

        $results = [];

        foreach ($request->sids as $sid) {
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
}
