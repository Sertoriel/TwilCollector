### Comandos Essenciais para Desenvolvimento Laravel

#### **Comandos Artisan (CLI do Laravel)**
Todos começam com `php artisan`

1. **Criação de Estruturas:**
   ```bash
   php artisan make:model Product -mcr
   ```
   - `make:model`: Cria um novo Eloquent model
   - `-m`: Cria migration associada
   - `-c`: Cria controller associado
   - `-r`: Cria controller com métodos resource (CRUD)
   - `Product`: Nome da classe/modelo

2. **Gerenciamento de Banco de Dados:**
   ```bash
   php artisan migrate --seed
   ```
   - `migrate`: Executa migrations pendentes
   - `--seed`: Roda seeders após migração
   - `migrate:rollback`: Reverte última migração
   - `migrate:refresh`: Reseta e reexecuta todas migrations

3. **Geração de Código:**
   ```bash
   php artisan make:controller UserController --resource --model=User
   ```
   - `--resource`: Cria métodos CRUD padrão
   - `--model`: Associa a um modelo existente

4. **Gerenciamento de Rotas:**
   ```bash
   php artisan route:list --except-vendor
   ```
   - Lista todas rotas registradas
   - `--except-vendor`: Oculta rotas de pacotes

5. **Otimização:**
   ```bash
   php artisan optimize:clear
   ```
   - Limpa todos caches (rotas, views, config)

6. **Tarefas Agendadas:**
   ```bash
   php artisan schedule:work
   ```
   - Executa agendador localmente para desenvolvimento

#### **Comandos Composer**
Gerenciador de dependências PHP

1. **Instalação de Pacotes:**
   ```bash
   composer require laravel/sanctum --dev
   ```
   - `require`: Instala pacote
   - `--dev`: Instala como dependência de desenvolvimento

2. **Atualização:**
   ```bash
   composer update --with-all-dependencies
   ```
   - Atualiza pacotes conforme `composer.json`
   - `--with-all-dependencies`: Atualiza dependências secundárias

3. **Autoload:**
   ```bash
   composer dump-autoload -o
   ```
   - Regenera autoloader
   - `-o`: Otimizado para produção

#### **Comandos PHP**
Execução de scripts PHP

1. **Servidor Embutido:**
   ```bash
   php -S 0.0.0.0:8000 -t public
   ```
   - `-S`: Inicia servidor embutido
   - `0.0.0.0`: Escuta em todas interfaces
   - `-t public`: Define diretório raiz

2. **Executar Scripts:**
   ```bash
   php -r "echo date('Y-m-d');"
   ```
   - `-r`: Executa código diretamente

#### **Comandos de Frontend (Node.js)**
1. **Instalação:**
   ```bash
   npm install --save-dev vite@latest
   ```
   - `--save-dev`: Salva como dependência de desenvolvimento

2. **Execução:**
   ```bash
   npm run dev -- --host
   ```
   - Executa Vite com hot-reload
   - `--host`: Disponibiliza em rede local

#### **Comandos de Sistema**
1. **Variáveis de Ambiente:**
   ```bash
   cp .env.example .env && php artisan key:generate
   ```
   - Cria arquivo env e gera chave de aplicação

2. **Permissões:**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```
   - Define permissões corretas para diretórios

### Comandos Avançados

#### **Artisan Avançado**
1. **Tinker (Shell Interativo):**
   ```bash
   php artisan tinker
   ```
   - Exemplo de uso:
   ```php
   >>> $user = new App\Models\User;
   >>> $user->name = 'Maria';
   >>> $user->save();
   ```

2. **Criação de Componentes:**
   ```bash
   php artisan make:component Input --view
   ```
   - Cria componente Blade com classe e view

3. **Testes:**
   ```bash
   php artisan test --testsuite=Feature --filter=UserTest
   ```
   - Executa testes específicos

#### **Composer Avançado**
1. **Diagnóstico:**
   ```bash
   composer diagnose
   ```
   - Verifica problemas no ambiente

2. **Scripts Personalizados:**
   ```json
   "scripts": {
       "deploy": [
           "php artisan optimize:clear",
           "npm run build"
       ]
   }
   ```
   ```bash
   composer run-script deploy
   ```

### Fluxo de Desenvolvimento Típico

1. **Novo Projeto:**
   ```bash
   composer create-project laravel/laravel:^11.0 meu-projeto
   cd meu-projeto
   cp .env.example .env
   php artisan key:generate
   ```

2. **Configurar Banco de Dados:**
   ```bash
   php artisan make:model Product -mcr
   # Edite a migration criada
   php artisan migrate
   ```

3. **Desenvolvimento:**
   ```bash
   php artisan make:controller ProductController --resource --model=Product
   # Implemente lógica no controller
   # Crie views em resources/views
   ```

4. **Frontend:**
   ```bash
   npm install
   npm run dev
   ```

5. **Testes:**
   ```bash
   php artisan make:test ProductTest
   php artisan test
   ```

6. **Preparação para Produção:**
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```

### Dicas de Produtividade

1. **Aliases Úteis (adicionar ao ~/.bashrc):**
   ```bash
   alias pa="php artisan"
   alias cu="composer update"
   alias ci="composer install"
   alias nrd="npm run dev"
   ```

2. **Comandos de Inspeção:**
   ```bash
   php artisan route:list
   php artisan storage:link
   php artisan db:show
   ```

3. **Solução de Problemas:**
   ```bash
   composer why-not laravel/framework:^11.0
   php --ini
   php -m
   ```

Documentação Oficial:  
[Artisan Commands](https://laravel.com/docs/11.x/artisan)  
[Composer CLI](https://getcomposer.org/doc/03-cli.md)