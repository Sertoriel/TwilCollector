# TwilCollector 📞📊

Bem-vindo ao **TwilCollector**! Este projeto é uma solução robusta para coletar e processar dados relacionados ao Twilio, com foco na extração de SIDs (IDs de sessão) e análise de mensagens. Ele combina o poder do framework Laravel para a parte web e de API, com scripts Python para processamento de dados.

## ✨ Funcionalidades Principais

- **Coleta de SIDs Twilio**: Extrai SIDs de mensagens do Twilio para análise posterior.
- **Processamento de Mensagens**: Scripts Python para categorizar e analisar mensagens com base em códigos de erro.
- **Interface Web (Laravel)**: Uma aplicação web para gerenciar e visualizar os dados coletados (a ser desenvolvida/explorada).
- **Automação**: Potencial para automação de tarefas de coleta e análise.

## 🚀 Tecnologias Utilizadas

Este projeto é construído com as seguintes tecnologias:

### Backend (Laravel/PHP)
- **PHP**: Linguagem de programação principal.
- **Laravel**: Framework PHP para desenvolvimento web e de APIs.
- **Composer**: Gerenciador de dependências para PHP.
- **Twilio PHP SDK**: Biblioteca oficial para interagir com a API do Twilio.

### Frontend (Node.js/JavaScript)
- **Node.js**: Ambiente de execução JavaScript.
- **npm/Yarn**: Gerenciadores de pacotes para Node.js.
- **Vite**: Ferramenta de build para frontend.
- **Tailwind CSS**: Framework CSS utilitário para estilização.

### Scripts de Processamento (Python)
- **Python**: Linguagem de programação para scripts de análise de dados.
- **pip**: Gerenciador de pacotes para Python.
- **`requirements.txt`**: Lista de dependências Python.

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter as seguintes ferramentas instaladas em seu sistema:

- **PHP** (versão 8.2 ou superior)
- **Composer**
- **Node.js** (versão 18 ou superior, recomendado)
- **npm** ou **Yarn**
- **Python** (versão 3.8 ou superior, recomendado)
- **pip** (geralmente vem com o Python)
- **Git**

## ⚙️ Instalação

Siga os passos abaixo para configurar o projeto em sua máquina local.

### 1. Clonar o Repositório

```bash
git clone https://github.com/seu-usuario/TwilCollector.git
cd TwilCollector
```

### 2. Configuração do Projeto Laravel

Navegue até o diretório do projeto Laravel:

```bash
cd LaravelV1/twilio-sids-reader
```

#### 2.1. Instalar Dependências PHP

```bash
composer install
```

#### 2.2. Configurar o Arquivo `.env`

Crie uma cópia do arquivo de exemplo `.env` e gere uma chave de aplicação:

```bash
cp .env.example .env
php artisan key:generate
```

Edite o arquivo `.env` e configure suas credenciais do Twilio, banco de dados e outras variáveis de ambiente necessárias. Exemplo:

```dotenv
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=your_auth_token
TWILIO_PHONE_NUMBER=+1234567890

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 2.3. Instalar Dependências Node.js

```bash
npm install # ou yarn install
```

#### 2.4. Compilar Assets Frontend

```bash
npm run dev # para desenvolvimento
# ou
npm run build # para produção
```

#### 2.5. Rodar Migrações do Banco de Dados

```bash
php artisan migrate
```

### 3. Configuração dos Scripts Python

Volte para o diretório raiz do projeto `TwilCollector`:

```bash
cd ../..
```

#### 3.1. Instalar Dependências Python

É altamente recomendável usar um ambiente virtual para as dependências Python:

```bash
python3 -m venv venv
source venv/bin/activate # No Windows: .\venv\Scripts\activate
pip install -r requirements.txt
```

## 🏃 Como Usar

### Iniciando o Servidor Laravel

No diretório `LaravelV1/twilio-sids-reader`:

```bash
php artisan serve
```

Isso iniciará o servidor de desenvolvimento do Laravel, geralmente em `http://127.0.0.1:8000`.

### Executando os Scripts Python

No diretório raiz do projeto `TwilCollector` (após ativar o ambiente virtual, se aplicável):

```bash
python3 Test.py # Exemplo de execução de um script
```

Consulte os scripts Python individuais para entender seus parâmetros e funcionalidades específicas.

## 📂 Estrutura do Projeto

```
TwilCollector/
├── LaravelV1/ # Contém o projeto Laravel (twilio-sids-reader)
│   └── twilio-sids-reader/
│       ├── app/ # Lógica da aplicação Laravel
│       ├── bootstrap/ # Configuração do framework
│       ├── config/ # Arquivos de configuração
│       ├── database/ # Migrações, seeders, factories
│       ├── public/ # Assets públicos e index.php
│       ├── resources/ # Views, JS, CSS
│       ├── routes/ # Definição de rotas
│       ├── storage/ # Arquivos gerados pelo Laravel
│       ├── tests/ # Testes automatizados
│       ├── vendor/ # Dependências PHP (gerenciadas pelo Composer)
│       ├── composer.json # Dependências PHP e scripts
│       ├── package.json # Dependências Node.js e scripts
│       └── .env.example # Exemplo de arquivo de variáveis de ambiente
├── requirements.txt # Dependências Python
├── Test.py # Exemplo de script Python
├── README.md # Este arquivo
└── .gitignore # Arquivo para ignorar arquivos/pastas no Git
```

## 🤝 Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests. Por favor, siga as boas práticas de desenvolvimento e mantenha o código limpo e documentado.

## 📄 Licença


---

