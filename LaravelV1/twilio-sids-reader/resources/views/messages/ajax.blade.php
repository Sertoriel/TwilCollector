<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Consulta AJAX Twilio</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <h2>Consulta de SIDs com AJAX</h2>
    <div class="mb-3">
        <label for="sids" class="form-label">Cole SIDs aqui (um por linha):</label>
        <textarea id="sids" class="form-control" rows="6"></textarea>
    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- <script>
        document.getElementById('upload').addEventListener('click', () => {
            const sids_file = document.getElementById('sids_file');


            if (!sids_file) {
              document.getElementById('log').textContent = '❌ Nenhum arquivo adicionado.';  
              return;
            };

            const reader = new FileReader();

            reader.onload = function(event) {
                const content = event.target.result;
                const sids = content.split('\n')
                .map(sid => sid.trim())
                .filter(sid => sid.length > 0);

                document.getElementById('log').textContent = '🔍 Lendo e enviando arquivo...\n';

                document.getElementById('sids').value = sids.join('\n');

                document.getElementById('log').textContent += `✔️ ${sids.length} SIDs enviados.\n`;
            }

        });
    </script> --}}
    <script>
        document.getElementById('buscar').addEventListener('click', () => {
            const sids = document.getElementById('sids').value
                .split('\n')
                .map(s => s.trim())
                .filter(s => s.length > 0);

            document.getElementById('log').textContent = '🔍 Iniciando busca...\n';
            document.querySelector('#resultados tbody').innerHTML = '';

            axios.post('/api/twilio/lookup', {
                    sids
                })
                .then(res => {
                    res.data.forEach(item => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${item.sid}</td>
                            <td>${item.status}</td>
                            <td>${item.error_code ?? ''}</td>
                            <td>${item.body ?? item.error_message}</td>
                        `;
                        document.getElementById('log').textContent +=
                            `✔️ ${item.sid} → ${item.status}\n`;
                        document.querySelector('#resultados tbody').appendChild(tr);
                    });
                })
                .catch(err => {
                    console.error('Detalhes do erro:', err.response.data);
                    
                    document.getElementById('log').textContent += '❌ Erro ao buscar mensagens.\n';
                    console.error(err);
                });
        });
    </script>
</body>

</html>
