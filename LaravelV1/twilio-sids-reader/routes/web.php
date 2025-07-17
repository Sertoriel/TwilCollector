<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageLogController;
use App\Http\Controllers\TwilcredSettingsController;

// ✅ Rota inicial redireciona para AJAX
Route::get('/', fn () => redirect()->route('messages.ajax'));

// ✅ Página AJAX
Route::get('/messages/ajax', fn () => view('messages.ajax'))->name('messages.ajax');

// CREDENCIAIS TWILIO
Route::post('/twilcred/settings', [TwilcredSettingsController::class, 'store'])->name('twilcred.settings.store');

// ✅ API para busca de SIDs
Route::post('/api/twilio/lookup', [MessageLogController::class, 'lookup']);

// ✅ API para leitura de arquivo
Route::post('/api/twilio/read-file', [MessageLogController::class, 'ReadFile']);

// Rotas adicionais para o navbar
Route::get('/history', function () {
    return view('history');
})->name('history');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/aurth/login', function (){
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');