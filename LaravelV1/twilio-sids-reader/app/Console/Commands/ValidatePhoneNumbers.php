<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

class ValidatePhoneNumbers extends Command
{
    protected $signature = 'validate:phones
                            {numbers?* : Números para validar (separados por espaço)}
                            {--f|file= : Caminho para arquivo com números (1 por linha)}';
    
    protected $description = 'Valida números via Twilio Lookup API';

    public function handle()
    {
        $accountSid = config('twilio.account_sid');
        $authToken = config('twilio.auth_token');
        
        if (!$accountSid || !$authToken) {
            $this->error('Credenciais Twilio não configuradas!');
            $this->error('Adicione no .env: TWILIO_SID, TWILIO_TOKEN');
            return 1;
        }

        $numbers = $this->getNumbers();
        
        if (empty($numbers)) {
            $this->error('Nenhum número fornecido!');
            $this->info('Uso: php artisan validate:phones +5511999999999');
            $this->info('Ou: php artisan validate:phones --file=numeros.txt');
            return 1;
        }

        $twilio = new Client($accountSid, $authToken);
        $validCount = 0;
        $results = [];

        $this->newLine();
        $this->info('Iniciando validação...');
        $progressBar = $this->output->createProgressBar(count($numbers));
        
        foreach ($numbers as $number) {
            try {
                $response = $twilio->lookups->v1->phoneNumbers($number)
                    ->fetch(["type" => "carrier"]);
                
                $isValid = ($response->carrier['type'] ?? '') === 'mobile';
                $isValid ? $validCount++ : null;

                $results[] = [
                    'number' => $number,
                    'valid' => $isValid,
                    'type' => $response->carrier['type'] ?? 'invalid',
                    'carrier' => $response->carrier['name'] ?? 'N/A'
                ];
            } catch (TwilioException $e) {
                $results[] = [
                    'number' => $number,
                    'valid' => false,
                    'type' => 'error',
                    'carrier' => $e->getMessage()
                ];
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        
        $this->newLine(2);
        $this->table(
            ['Número', 'Válido?', 'Tipo', 'Operadora/Erro'],
            $results
        );
        
        $this->info("Resultados: {$validCount}/" . count($numbers) . " válidos");
        $this->newLine();
    }

    private function getNumbers(): array
    {
        $numbers = $this->argument('numbers');
        
        if ($filePath = $this->option('file')) {
            if (!file_exists($filePath)) {
                $this->error("Arquivo não encontrado: {$filePath}");
                return [];
            }
            
            $fileNumbers = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            return array_merge($numbers, $fileNumbers);
        }
        
        return $numbers;
    }
}