<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class MessageLookupController extends Controller
{
    public function index()
    {
        // página inicial: só o formulário
        return view('messages.form');
    }

    public function lookup(Request $request)
    {
        set_time_limit(300); // desabilita timeout para grandes listas 5mim
        // 1️⃣ Validação
        $data = $request->validate([
            'sids_text'   => 'nullable|string',
            'sids_file'   => 'nullable|file|mimes:txt',
        ]);

        // 2️⃣ Extrair SIDs (de textarea + de arquivo, se existir)
        $sids = collect();

        if (!empty($data['sids_text'])) {
            $sids = $sids
                ->merge(preg_split('/\r?\n/', trim($data['sids_text'])));
        }

        if ($request->hasFile('sids_file')) {
            $fileLines = file($request->file('sids_file')->getRealPath());
            $sids = $sids->merge($fileLines);
        }

        // sanitizar
        $sids = $sids
            ->map(fn($sid) => trim($sid))
            ->filter()                         // remove vazios
            ->unique();                       // evita duplicatas

        // 3️⃣ Credenciais Twilio
        $client = new Client(
            config('twilio.account_sid'),
            config('twilio.auth_token')
        );

        // 4️⃣ Consulta cada SID
        $results = $sids->map(function ($sid) use ($client) {
            try {
                $m = $client->messages($sid)->fetch();
                return [
                    'sid'        => $sid,
                    'status'     => $m->status,
                    'error_code' => $m->errorCode ?? 0,
                    'body'       => $m->body,
                ];
            } catch (\Throwable $e) {
                return [
                    'sid'        => $sid,
                    'status'     => 'lookup_error',
                    'error_code' => $e->getCode(),
                    'body'       => $e->getMessage(),
                ];
            }
        });

        // 5️⃣ Envia para a view
        return view('messages.form', [
            'results' => $results,
        ]);
    }
}
// End of file
// This file is part of the Twilio SIDs Reader project.