<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Тестовое задание REST API сервер

Сайт запускается на хосте - https://assignment.sinepolsky.website/

Сборка локального проекта

1) <code>docker-compose up --build</code>
2) создать файл с настройками <code>cp .env.example .env</code> (настроить конфигурацию)
3) <code>docker exec rest_api_app composer install --ignore-platform-reqs</code>
4) <code>docker exec rest_api_app php artisan config:cache</code>
5) <code>docker exec rest_api_app php artisan migrate</code>
6) <code>docker exec rest_api_app php artisan db:seed</code>
7) <code>docker exec rest_api_app php composer dump-autoload</code>
8) <code>docker exec rest_api_app npm install</code>

##

Локальная ссылка - http://localhost/

phpMyAdmin на - http://localhost:8080/ пароль и логин root таблица root

Установка пакетов laravel через <code>docker exec rest_api_app composer require package/name</code>

Для сборки фронта запускаем <code>docker exec rest_api_app npm run dev|watch|prod</code>

Установка пакетов npm через <code>docker exec rest_api_app npm i package-name</code>

### Конфигурация

Версия php: <code>8.0</code><br>
Версия NodeJS: <code>12.x</code><br>
Версия npm: <code>6.14.16</code><br>
Версия Laravel: <code>^9.19</code><br>
