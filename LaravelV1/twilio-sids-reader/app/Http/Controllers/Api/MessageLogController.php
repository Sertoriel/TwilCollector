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
            'sids.*' => 'required|string'
        ]);

        $client = new Client(
            config('twilio.account_sid'),
            config('twilio.auth_token')
        );

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
