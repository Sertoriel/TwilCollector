<?php

namespace App\Http\Controllers;

use App\Models\Twilcred_Settings;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TwilcredSettingsController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'account_sid' => [
                'required',
                'string',
                'starts_with:AC',
                'size:34'
            ],
            'auth_token' => ['required', 'string', 'size:32'],
            'profile' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        
        $existingProfile = Twilcred_Settings::where('profile', $validated['profile'])->first();

        try{

            Twilcred_Settings::Create(
            [
                'account_sid' => Crypt::encryptString($validated['account_sid']),
                'auth_token' => Crypt::encryptString($validated['auth_token']),
                'profile' => $validated['profile'],

                'password' => Hash::make($validated['password']),

                'uuid' =>Str::uuid(),
            ]
            );

        return back()->with('message', 'Credentials saved successfully.');

        } catch (\Exception $e) {
            \Log::error('erro ao salvar credenciais: ' . $e->getMessage());

            return back()->with('error', 'Falha ao Registrar.');
        }
        
    }

    public function log_in(Request $request)
    {
        $request->validate([
            'profile' => 'required|string',
            'password' => 'required|string'
        ]);

        $profile = Twilcred_Settings::where('profile', $request->profile)->first();

        if(!$profile || !hash::check($request->password, $profile->password)) {
            sleep(5);
            return back()->withErrors([
                'profile' => 'Credenciais invalidas.'
            ]);
        }

        session([
            'twilcred_authenticated' => true,
            'twilcred_profile' => $profile->profile,
            'twilcred_sid' => Crypt::decryptString($profile->account_sid),
            'twilcred_token' => Crypt::decryptString($profile->auth_token)
        ]);

        return back()->with(['profile' => 'Autenticação completa.']);

        sleep(5);

        return redirect()->route('messages.index');

    }

    public function log_out(Request $request)
    {
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
