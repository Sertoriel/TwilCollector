@extends('layouts.app')

@section('title', '📲 Register Twilio SIDs Reader')

@section('content')
    <form action="{{ route('twilcred.settings.register') }}" method="POST">
        @csrf
        <p>Preencha os dados da sua conta Twilio para Registro de Perfil.</p>
        <div class="mb-3">
            <label for="twilioaccount_sid" class="form-label">SID da Conta Twilio:</label>
            <input type="text" name="account_sid" id="twilioaccount_sid" class="form-control"
                placeholder="Digite o SID da conta aqui" value="{{ $TwilcredSettings->account_sid ?? '' }}">
            <label for="AuthToken" class="form-label">Token de Autenticação:</label>
            <input type="text" name="auth_token" id="AuthToken" class="form-control"
                placeholder="Digite o token de autenticação aqui" value="{{ $TwilcredSettings->auth_Token ?? '' }}">
            <label for="Profile" class="form-label">Nome do Perfil:</label>
            <input type="text" name="profile" id="profile" class="form-control"
                placeholder="Nomeie seu perfil de uso aqui" value="{{ $TwilcredSettings->profile ?? '' }}"
            <label for="Pass_word" class="form-label">Senha:</label>
            <input type="password" name="password" id="Pass_word" class="form-control"
                placeholder="Digite a senha aqui" value="{{ $TwilcredSettings->password ?? '' }}">
            <button type="submit" class="btn btn-primary mt-2">Register</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app/twilio/clsaj.js') }}"></script>
@endsection
