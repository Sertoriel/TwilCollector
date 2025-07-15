<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageLookupController;
use App\Http\Controllers\Api\MessageLogController;

// ✅ Rota inicial redireciona para AJAX
Route::get('/', fn () => redirect()->route('messages.ajax'));

// ✅ Página AJAX
Route::get('/messages/ajax', fn () => view('messages.ajax'))->name('messages.ajax');

// ✅ API para busca de SIDs
Route::post('/api/twilio/lookup', [MessageLogController::class, 'lookup']);

// ✅ API para leitura de arquivo
Route::post('/api/twilio/read-file', [MessageLogController::class, 'ReadFile']);
