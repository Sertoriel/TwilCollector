<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Twilcred_Settings extends Model
{
    protected $fillable = [
        'account_sid',
        'auth_token',
        'profile',
        'password',
    ];

    // // Método para obter as credenciais de Twilio
    // public static function getCredentials()
    // {
    //     $settings = self::first();
    //     return [
    //         'account_sid' => $settings ? Crypt::decryptString($settings->account_sid) : config('twilio.account_sid'),
    //         'auth_token' => $settings ? Crypt::decryptString($settings->auth_token) : config('twilio.auth_token'),
    //     ];
    // }
}
