@extends('layouts.app')

@section('title', 'Login Twilio SIDs Reader')

@section('content')
    <form action="{{ route('twilcred.settings.store') }}" method="POST">
        @csrf
        <p>Preencha os dados da sua conta Twilio para realizar as consultas.</p>
        <div class="mb-3">
            <label for="twilioaccount_sid" class="form-label">SID da Conta Twilio:</label>
            <input type="text" name="account_sid" id="twilioaccount_sid" class="form-control"
                placeholder="Digite o SID da conta aqui" value="{{ $TwilcredSettings->account_sid ?? '' }}">
            <label for="AuthToken" class="form-label">Token de Autenticação:</label>
            <input type="text" name="auth_token" id="AuthToken" class="form-control"
                placeholder="Digite o token de autenticação aqui" value="{{ $TwilcredSettings->Auth_Token ?? '' }}">
            <button type="submit" class="btn btn-primary mt-2">Salvar Creds</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app/twilio/clsaj.js') }}"></script>
@endsection
