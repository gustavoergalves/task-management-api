build:
	docker-compose build

init:
	docker-compose exec app composer install
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate:fresh --seed

install:
	docker-compose exec app composer install

down:
	docker compose down

up:
	docker-compose up -d

php_shell:
	docker-compose exec app sh

migration:
	docker-compose exec app php artisan make:migration

migrate:
	docker-compose exec app php artisan migrate --force

migrate_rollback:
	docker-compose exec app php artisan migrate:rollback

clear_caches:
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear

test:
	docker-compose exec app php artisan test

lint:
	docker-compose exec app ./vendor/bin/pint

lint_check:
	docker-compose exec app ./vendor/bin/pint --test

stan:
	docker-compose exec app ./vendor/bin/phpstan analyse --memory-limit=256M

audit:
	docker-compose exec app composer audit

code_review:
	@echo "Running code review checks..."
	@make lint_check
	@make stan
	@make audit
	@make test
	@echo "✅ All code review checks passed!"
