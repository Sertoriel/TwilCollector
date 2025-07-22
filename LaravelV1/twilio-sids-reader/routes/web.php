<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageLogController;
use App\Http\Controllers\TwilcredSettingsController;

// ✅ Rota inicial redireciona para AJAX
Route::get('/', fn () => redirect()->route('messages.index'));

// ✅ Página Principal
Route::get('/messages/index', fn () => view('messages.index'))->name('messages.index');

// CREDENCIAIS de Registro TWILIO
Route::post('/twilcred/settings/register', [TwilcredSettingsController::class, 'register'])->name('twilcred.settings.register');
//Log-in
Route::post('/twilcred/settings/login', [TwilcredSettingsController::class, 'log_in'])->name('twilcred.settings.log_in');
//Log-out

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
    return view('auth.register');
})->name('register');