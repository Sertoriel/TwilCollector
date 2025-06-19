<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageLookupController;


Route::get('/messages', function () {
    return view('messages');
});

Route::get ('/messages',        [MessageLookupController::class, 'index'])->name('messages.form');
Route::post('/messages/lookup', [MessageLookupController::class, 'lookup'])->name('messages.lookup');
