## Validate .env content inside : deployment/
```
PROJECT_NAME=keyeduau
USER=apache
UID=1000
MYSQL_ENTRYPOINT_INITDB=./mysql/docker-entrypoint-initdb.d
PHP_MEMORY_LIMIT=512M
### NGINX ###############
NGINX_HOST_HTTP_PORT=80
NGINX_HOST_HTTPS_PORT=443
NGINX_HOST_LOG_PATH=./logs/nginx/
NGINX_SITES_PATH=./nginx/sites/
NGINX_PHP_UPSTREAM_CONTAINER=php-fpm
NGINX_PHP_UPSTREAM_PORT=9000
NGINX_SSL_PATH=./nginx/ssl/
TIMEZONE=UTC
REDIS_PORT=6379
PUID=1000 // linux user id
PGID=1000 // linux usergroup id
```
## Build Images
``` 
docker-compose -f ./deployment/docker-compose.yaml build
```
## Run App
```
docker-compose -f ./deployment/docker-compose.yaml up -d
```
## Initialize Composer packages
```
docker-compose -f ./deployment/docker-compose.yaml exec app composer install
```
## Seeding Database 
```
docker-compose -f ./deployment/docker-compose.yaml exec app php artisan db:seed 
```
## Initialize Pest
```
./vendor/bin/pest --init
```
## Run Test
```
./vendor/bin/pest
```
## Create new Test
```
php artisan pest:test TodoTest --unit
```
## Reference
- How to Unit Test a Laravel API with the Pest Framework
https://www.twilio.com/blog/unit-test-laravel-api-pest-framework
