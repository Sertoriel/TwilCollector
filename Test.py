from twilio.rest import Client
from dotenv import load_dotenv
import os

# Carrega variáveis de ambiente do arquivo .env
load_dotenv()

# CONFIGURAÇÕES
ACCOUNT_SID = os.getenv('TWILIO_ACCOUNT_SID')
AUTH_TOKEN = os.getenv('TWILIO_AUTH_TOKEN')
ARQUIVO_DE_SIDS = 'sids.txt'
ARQUIVO_DE_SAIDA = 'mensagens_extraidas.txt'

# Inicializa cliente da Twilio
client = Client(ACCOUNT_SID, AUTH_TOKEN)

def carregar_sids(arquivo):
    with open(arquivo, 'r') as f:
        return [linha.strip() for linha in f if linha.strip()]

def extrair_mensagens(sids):
    resultados = []
    for sid in sids:
        try:
            mensagem = client.messages(sid).fetch()
            resultados.append(f"{sid}: {mensagem.body}")
        except Exception as e:
            resultados.append(f"{sid}: ERRO AO BUSCAR MENSAGEM - {str(e)}")
    return resultados

def salvar_em_arquivo(linhas, arquivo_saida):
    with open(arquivo_saida, 'w', encoding='utf-8') as f:
        for linha in linhas:
            f.write(linha + '\n')
    print(f"Mensagens salvas em: {arquivo_saida}")

if __name__ == '__main__':
    sids = carregar_sids(ARQUIVO_DE_SIDS)
    mensagens = extrair_mensagens(sids)
    salvar_em_arquivo(mensagens, ARQUIVO_DE_SAIDA)
