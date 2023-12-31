source_path=./deployment/docker-compose.yaml
EXEC_ARGS?=php artisan --version
build:
	docker-compose -f $(source_path) build
up:
	docker-compose -f $(source_path) up -d
down:
	docker-compose -f $(source_path) down --remove-orphans
test:
	docker-compose -f $(source_path) exec app composer test
format:
	docker-compose -f $(source_path) exec app composer format
tinker:
	docker-compose -f $(source_path) exec app php artisan tinker
optimize:
	docker-compose -f $(source_path) exec app php artisan optimize
view-cache:
	docker-compose -f $(source_path) exec app php artisan view:cache
clear:
	docker-compose -f $(source_path) exec app php artisan optimize:clear
route-list:
	docker-compose -f $(source_path) exec app php artisan route:list
fresh-seed:
	docker-compose -f $(source_path) exec app php artisan migrate:fresh --seed
update-package:
	docker-compose -f $(source_path) exec app composer update
dump:
	docker-compose -f $(source_path) exec app composer dump
bash:
	docker-compose -f $(source_path) exec app bash
exec-app:
	docker-compose -f $(source_path) exec app $(EXEC_ARGS)
