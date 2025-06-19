<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageLookupController;
use App\Http\Controllers\Api\MessageLogController;

Route::get('/messages', function () {
    return view('messages');
});

Route::get ('/messages',        [MessageLookupController::class, 'index'])->name('messages.form');
Route::post('/messages/lookup', [MessageLookupController::class, 'lookup'])->name('messages.lookup');

Route::post('/twilio/lookup', [MessageLogController::class, 'lookup']);

Route::get('/messages/ajax', fn () => view('messages.ajax'))->name('messages.ajax');