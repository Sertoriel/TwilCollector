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
        ]);
        
        Twilcred_Settings::updateOrCreate(
            ['id' => 1], // Assuming you want to store only one set of credentials
            [
                'account_sid' => Crypt::encryptString($validated['account_sid']),
                'auth_token' => Crypt::encryptString($validated['auth_token']),
            ]
            );

        return back()->with('message', 'Credentials saved successfully.');
    }
}
