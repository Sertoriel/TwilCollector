<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Twilcred_Settings extends Model
{

    protected $table = 'twilcred_settings';
    

    protected $fillable = [
        'account_sid',
        'auth_token',
        'profile',
        'password',
    ];


    public function messageLogs()
    {
        return $this->hasMany(MessageLog::class);
    }
    
}
