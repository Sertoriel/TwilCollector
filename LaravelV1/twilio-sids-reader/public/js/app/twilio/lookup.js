// Upload de arquivo
document.getElementById('upload')?.addEventListener('click', async () => {

    document.getElementById('log').textContent = '📤 Enviando arquivo...\n';

    await new Promise(resolve => setTimeout(resolve, 1000)); // Simula um atraso de 1 segundo

    if(!document.getElementById('sids_file').files.length) {
        document.getElementById('log').textContent = '❌ Nenhum arquivo selecionado.\n';
        return;
    }

    const file = document.getElementById('sids_file').files[0];
    const formData = new FormData();
    formData.append('sids_file', file);

    axios.post('/api/twilio/read-file', formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => {
        const sids = res.data.sids;
        document.getElementById('sids').value = sids.join('\n');
        document.getElementById('log').textContent += `✔️ ${sids.length} SIDs lidos do arquivo.\n`;
    })
    .catch(err => {
        console.error('Erro ao ler arquivo:', err);
        document.getElementById('log').textContent += '❌ Erro ao ler arquivo.\n';
    });
});

// Busca de mensagens
document.getElementById('buscar')?.addEventListener('click', () => {
    const sids = document.getElementById('sids').value
        .split('\n')
        .map(s => s.trim())
        .filter(s => s.length > 0);

    document.getElementById('log').textContent = '🔍 Iniciando busca...\n';
    document.querySelector('#resultados tbody').innerHTML = '';

    axios.post('/api/twilio/lookup', { sids }, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
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
            document.getElementById('log').textContent += `✔️ ${item.sid} → ${item.status}\n`;
            document.querySelector('#resultados tbody').appendChild(tr);
        });
    })
    .catch(err => {
        console.error('Detalhes do erro:', err.response?.data);
        document.getElementById('log').textContent += '❌ Erro ao buscar mensagens.\n';
    });
});