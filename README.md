# SyncMusic API - Backend
    API desenvolvida em Laravel 11 para o projeto SyncMusic, uma rede social para amantes de música compartilharem seus posts, curtidas, comentários e muito mais.

# Tecnologias utilizadas
    PHP 8.2+

    Laravel 11

    MySQL

    Sanctum (Autenticação API)

    Eloquent ORM

    Docker (opcional)

    Composer 2

# Pré-requisitos
    PHP 8.2 ou superior

    Composer 2 instalado

    MySQL rodando na máquina
# Instale as dependências PHP:
    composer install
# Configure o ambiente:
    Copie o arquivo .env.example para .env:
    cp .env.example .env
    Abra o arquivo .env e configure o banco de dados:

    env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=syncmusic
    DB_USERNAME=root
# Gerar chave da aplicação
    php artisan key:generate

# Rodar as migrations + seeders (dados fake)
    php artisan migrate --seed

# Subir o servidor local

    php artisan serve --host=localhost --port=8000
