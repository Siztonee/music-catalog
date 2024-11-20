<p align="center">Инструкция по запуску</p>

После запуска локального сервера с БД:

1. composer install
2. php artisan key:generate
3. php artisan migrate
4. Заходите в Postman и тестируете.


Имеется CRUD:

1. /api/artists
2. /api/songs
3. /api/albums

Документация Swagger: /api/documentation