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
    'twilcred_settings_id',
];

public function profile()
{
    return $this->belongsTo(Twilcred_Settings::class);
}

}
