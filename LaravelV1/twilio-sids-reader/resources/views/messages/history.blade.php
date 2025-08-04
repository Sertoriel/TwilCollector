@extends('layouts.app')

@section('title', '📲 Historico Twilio SIDs Reader')

@section('content')
    <h2>Historico de Buscas📲</h2>
    <p>Este é o histórico de buscas realizadas com os SIDs do Twilio. Você pode visualizar os detalhes de cada busca.</p>
    <form method="GET" action="{{ route('get.history') }}">
        <div class="d-flex justify-content-center mt-4">
            {{ $history->links('pagination::bootstrap-5') }} <!-- Paginação corrigida -->
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>SID</th>
                    <th>Status</th>
                    <th>Mensagem</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $entry)
                    <!-- Altere para $history -->
                    <tr>
                        <td>{{ $entry->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $entry->sid }}</td>
                        <td>{{ $entry->status }}</td>
                        <td>
                            {{-- <small>Perfil: {{ $entry->profile->profile }}</small> --}}
                            <br>
                            @if ($entry->status === 'erro')
                                ERRO: {{ $entry->error_message }} <!-- Mostra erro -->
                            @else
                                {{ Str::limit($entry->body, 100) }} <!-- Mostra corpo da mensagem -->
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    <div class="d-flex justify-content-center mt-4">
        {{ $history->links('pagination::bootstrap-5') }} <!-- Paginação corrigida -->
    </div>
    <div class="mt-3">
        <a href="{{ route('messages.index') }}" class="btn btn-secondary">Voltar para a página inicial</a>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app/twilio/clsaj.js') }}"></script>
@endsection
