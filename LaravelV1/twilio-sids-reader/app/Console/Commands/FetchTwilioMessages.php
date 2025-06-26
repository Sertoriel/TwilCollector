<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;

class FetchTwilioMessages extends Command
{
    // Nome e assinatura do comando artisan
    protected $signature = 'twilio:fetch-messages
                            {--sids= : Caminho para o arquivo de SIDs (default: sids.txt)}
                            {--output= : Caminho para o arquivo de saída (default: mensagens_extraidas.txt)}';

    protected $description = 'Busca bodies das mensagens da Twilio pelos SIDs e salva em um .txt';

    public function handle()
    {
        // Carrega credenciais do .env
        $accountSid = config('twilio.account_sid');
        $authToken  = config('twilio.auth_token');

        // Define caminhos de arquivos
        $sidsFile    = $this->option('sids') ?: base_path('sids.txt');
        $outputFile  = $this->option('output') ?: base_path('mensagens_extraidas.txt');

        // Lê SIDs
        if (!file_exists($sidsFile)) {
            $this->error("Arquivo de SIDs não encontrado: {$sidsFile}");
            return 1;
        }
        $sids = array_filter(array_map('trim', file($sidsFile)));

        // Inicializa client da Twilio
        $client = new Client($accountSid, $authToken);

        $lines = [];
        foreach ($sids as $sid) {
            try {
                // Busca mensagem pelo SID
                $message = $client->messages($sid)->fetch();

                //Extração de Erros Se houver
                $body = $message->body;
                $status = $message->status;
                $errorCode = $message->errorCode ?? '0';
                $to = $message->to ?? '';
                $errorMsg = $message->errorMessage ?? '';
                $dateSent = $message->dateSent ? $message->dateSent->format('Y-m-d H:i:s') : 'N/A';
                $dateCreated = $message->dateCreated ? $message->dateCreated->format('Y-m-d H:i:s') : 'N/A';

                //Linhas de Saida
                $lines[] = sprintf(
                    "SID: %s | Status: %s | Erro: %s (%s) | Mensagem/body: %s | To: %s | Data Envio: %s | Data Criação: %s",
                    $sid, $status, $errorCode, $errorMsg, str_replace(["\r, ", "\n"], '', $body), $to, $dateSent, $dateCreated
                );

                $this->info("SID OK:  {$sid} (Message Sts: {$status})");
            } catch (\Exception $e) {
                $lines[] = "{$sid} | ERRO AO BUSCAR - {$e->getMessage()}";
                $this->error("SID ERR: {$sid}");
            }
        }

        // Salva resultado
        file_put_contents($outputFile, implode(PHP_EOL, $lines) . PHP_EOL);
        $this->info("Mensagens salvas em: {$outputFile}");

        return 0;
    }
}
