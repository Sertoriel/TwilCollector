@extends('layouts.app')

@section('title', '📲 Login Twilio SIDs Reader')

@section('content')
    <form action="{{ route('twilcred.settings.log_in') }}" method="POST">
        @csrf
        <p>Preencha os dados da sua conta Twilio para realizar as consultas.</p>
        <div class="mb-3">
            <label for="profile" class="form-label">Nome do Perfil:</label>
            <input type="text" name="profile" id="profile" class="form-control"
                placeholder="Digite o nome da conta aqui" value="{{ $TwilcredSettings->profile ?? '' }}">
            <label for="Pass_word" class="form-label">Senha:</label>
            <input type="password" name="password" id="Pass_word" class="form-control"
                placeholder="Digite a senha aqui" value="{{ $TwilcredSettings->password ?? '' }}">
            <button type="submit" class="btn btn-primary mt-2">Log-in</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app/twilio/clsaj.js') }}"></script>
@endsection
