# API de Venda de Jogos Digitais
[![License](https://img.shields.io/npm/l/react)](https://github.com/jdorres/game-sale-api/blob/main/LICENSE)
![status](https://img.shields.io/badge/status-Em%20desenvolvimento-red)


# Descrição

API desenvolvida para um projeto de vendas de jogos digitais

# Tecnologias utilizadas
- PHP v8.2
- Laravel v11.9
- Mysql v8.0
- Nginx v1.27

# Instalação via Docker Compose

Clonar repositório:

    git clone https://github.com/jdorres/game-sale-api

Acessar projeto

    cd game-sale-api/


Duplicar o .env
    
    cp .env.example .env

Faça o build do projeto

    docker compose build --no-cache

Inicie o container

    docker compose up -d

Acesse o container criado

    docker compose exec -it game-sale-api bash

Dentro do container execute os comandos de instalação.

    composer install
    php artisan migrate:install
    php artisan migrate
    php artisan db:seed
    php artisan jwt:secret

Conceder permissões aos arquivos
    
    chmod 777 -R storage/framework 
    chmod 777 -R storage/logs
    chmod 777 -R storage/app
    chmod 777 -R bootstrap/cache


# Instruções de uso


# Autor
Julio Dorres

https://www.linkedin.com/in/julio-d-moreira