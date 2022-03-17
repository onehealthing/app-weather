## Weather app


#### Build docker
``docker-compose up -d --build``

#### Generate key
``docker-compose exec app php artisan key:generate``

#### Configure .env file
```
CACHE_DRIVER=redis
REDIS_CLIENT=predis
REDIS_HOST=redis
REDIS_PASSWORD=your_pass
REDIS_PORT=6379

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

PASSPORT_PERSONAL_ACCESS_CLIENT_ID=
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=
```

#### Install composer
``docker-compose exec app composer install``

#### Make pre-deployment vulnerability scan
``docker-compose exec app php artisan security:check``

#### Generate swagger file with the description
``docker-compose exec app php artisan l5-swagger:generate``

#### Swagger file with the description
``{host}/api/documentation``

#### Configure Laravel passport:
- ``docker-compose exec app php artisan migrate``
- ``docker-compose exec app php artisan passport:install``
