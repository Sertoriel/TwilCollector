@extends('layouts.app')

@section('title', '📲 Twilio SIDs Reader')

@section('content')
    <h2>Easy Log Finder Twilio📲</h2>
    <div class="mb-3">
        <label for="sids" class="form-label">Cole SIDs aqui (um por linha):</label>
        <textarea id="sids" class="form-control" rows="6"></textarea>
    </div>
    {{-- 📚 ENVIO DOS ARQUIVOS!!! --}}
    <div class="mb-3">
        <label class="form-label fw-bold">…ou envie um arquivo .txt</label>
        <input id="sids_file" type="file" class="form-control">
        <button id="upload" type="submit" class="btn btn-secondary mt-2">Enviar Arquivo</button>
    </div>

    <button id="buscar" class="btn btn-primary mb-3">Buscar Mensagens</button>

    <h5>Log de Busca</h5>
    <pre id="log" class="bg-light p-3 border" style="height: 200px; overflow-y: scroll;"></pre>

    <h5>Resultados</h5>
    <table class="table table-bordered" id="resultados">
        <thead>
            <tr>
                <th>SID</th>
                <th>Status</th>
                <th>Erro</th>
                <th>Mensagem</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app/twilio/lookup.js') }}"></script>
    <script src="{{ asset('js/app/twilio/clsaj.js') }}"></script>
@endsection