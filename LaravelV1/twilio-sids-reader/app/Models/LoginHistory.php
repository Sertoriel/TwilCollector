<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    //
    
    protected $table = 'LoginHistory';
    
    protected $fillable = [
        'profile',
        'ip_address',
        'user_agent',
        'login_at',
        'logout_time',
        'session_id',
    ];
}
