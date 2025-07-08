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
        $request->validate([
            'sids' => 'required|array',
            'sids.*' => 'required|string',
        ]);

        $client = new Client(
            config('twilio.account_sid'),
            config('twilio.auth_token')
        );

        $results = [];

        foreach ($request->sids as $sid) {
            try {
                // 1️⃣ Busca a mensagem
                $msg = $client->messages($sid)->fetch();

                // 2️⃣ Busca, via Monitor Events, o parentSid (FT...) para este Message SID
                $events = $client
                    ->monitor
                    ->v1
                    ->events
                    ->read([
                        'resourceSid' => $sid,
                        'limit'       => 20,
                    ]);

                // procura um evento de execução de Studio
                $executionSid = collect($events)
                    ->first(fn($e) =>
                        str_starts_with($e->eventType, 'studio.flow.execution')
                    )?->parentSid;

                // 3️⃣ Grava no banco
                $log = MessageLog::create([
                    'sid'           => $sid,
                    'status'        => $msg->status,
                    'error_code'    => $msg->errorCode,
                    'body'          => $msg->body,
                    'error_message' => $msg->errorMessage,
                    'execution_sid' => $executionSid,   // novo campo no model/migration
                ]);

                $results[] = $log->toArray();
            }
            catch (\Throwable $e) {
                $log = MessageLog::create([
                    'sid'           => $sid,
                    'status'        => 'erro',
                    'error_code'    => $e->getCode(),
                    'body'          => null,
                    'error_message' => $e->getMessage(),
                    'execution_sid' => null,
                ]);

                $results[] = $log->toArray();
            }
        }

        return response()->json($results);
    }
}
// This controller handles the lookup of message logs by their SIDs.
// It validates the input, fetches message details from Twilio, retrieves related events,
// and stores the results in the database. If an error occurs, it logs the error details
// and returns the results in a JSON response.  