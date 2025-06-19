@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Consulta de Mensagens Twilio</h1>

        {{-- FORMULÁRIO --}}
        <form action="{{ route('messages.lookup') }}" method="POST" enctype="multipart/form-data" class="mb-5">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Cole SIDs (um por linha)</label>
                <textarea name="sids_text" class="form-control" rows="6">{{ old('sids_text') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">…ou envie um arquivo .txt</label>
                <input type="file" name="sids_file" class="form-control">
            </div>

            <button class="btn btn-primary">Buscar mensagens</button>
        </form>

        {{-- RESULTADOS --}}
        @isset($results)
            <h2>Resultados ({{ $results->count() }})</h2>
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>SID</th>
                        <th>Status</th>
                        <th>Cód. Erro</th>
                        <th>Body</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $r)
                        <tr
                            class="{{ $r['status'] === 'failed' ? 'table-danger' : ($r['status'] === 'delivered' ? 'table-success' : '') }}">
                            <td class="text-monospace">{{ $r['sid'] }}</td>
                            <td>{{ $r['status'] }}</td>
                            <td>{{ $r['error_code'] }}</td>
                            <td>{{ Str::limit($r['body'], 120) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endisset
    </div>
@endsection
