@extends('layouts.app')

@section('title', '📲 Historico Twilio SIDs Reader')

@section('content')
    <h2>Historico de Buscas📲</h2>
    <p>Este é o histórico de buscas realizadas com os SIDs do Twilio. Você pode visualizar os detalhes de cada busca.</p>
    <form method="GET" action="{{ route('get.history') }}">
        <table class="table table-bordered">
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
                            @if ($entry->status === 'erro')
                                ERRO: {{ $entry->error_message }} <!-- Mostra erro -->
                            @else
                                {{ $entry->body }} <!-- Mostra corpo da mensagem -->
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    <div class="mt-3">
        {{ $history->links() }} <!-- Paginação corrigida -->
    </div>
    <div class="mt-3">
        <a href="{{ route('messages.index') }}" class="btn btn-secondary">Voltar para a página inicial</a>
    </div>
@endsection
