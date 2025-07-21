<?php

namespace App\Http\Controllers;

use App\Models\Twilcred_Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TwilcredSettingsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_sid' => 'required|string',
            'auth_token' => 'required|string',
            'password' => 'required|string',
        ]);
        
        Twilcred_Settings::updateOrCreate(
            ['id'],
            [
                'account_sid' => Crypt::encryptString($validated['account_sid']),
                'auth_token' => Crypt::encryptString($validated['auth_token']),
                'password' => Crypt::encryptString($validated['password']),
            ]
            );

        return back()->with('message', 'Credentials saved successfully.');
    }

    public function log_in()
    {

    }
}
