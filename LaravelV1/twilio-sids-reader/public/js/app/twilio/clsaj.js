document.addEventListener('DOMContentLoaded', () => {
    //limpa os campos de log-in
    document.getElementById('account_sid').value = '';
    document.getElementById('auth_token').value = '';
    // Limpa textarea de SIDs
    document.getElementById('sids').value = '';
    
    // Limpa input de arquivo
    document.getElementById('sids_file').value = '';
    
    // Limpa área de log
    document.getElementById('log').textContent = '';
    
    // Limpa tabela de resultados
    document.querySelector('#resultados tbody').innerHTML = '';
});