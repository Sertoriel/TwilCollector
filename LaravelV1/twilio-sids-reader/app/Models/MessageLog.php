<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    protected $fillable = [
        'sid',
        'status',
        'error_code',
        'body',
        'error_message',
        'execution_sid',  // incluído
    ];
}
