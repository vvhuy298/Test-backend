up:
	docker-compose up -d app web db mailhog

down:
	docker-compose down

app-init:
	docker-compose exec app sh -c ' \
		cp .env.local .env && \
		chmod -R 777 /app/storage && \
		php -d memory_limit=-1 /usr/bin/composer install && \
		composer install && \
		php artisan storage:link && \
		php artisan key:generate && \
		php artisan jwt:secret'

app-clear:
	docker-compose exec app composer dump-autoload
	docker-compose exec app php artisan optimize:clear

app-db-fresh:
	docker-compose exec app sh -c ' \
		php artisan migrate:fresh --seed'

app-tinker:
	docker-compose exec app php artisan tinker

app-route:
	docker-compose exec app php artisan route:list

app-phpcs:
	docker-compose exec app composer phpcs

app-phpmd:
	docker-compose exec app composer phpmd

app-phpunit:
	docker-compose exec app composer phpunit