GPG_PATH=${GPG_PATH}

compose-bash:
	docker-compose exec app bash

compose-migrate:
	docker-compose exec app bash -c "cd ./src && php artisan migrate"

compose-migrate-prev:
	docker-compose exec app bash -c "cd ./src && php artisan migrate:rollback"

compose-up:
	docker-compose up --build -d

compose-down:
	docker-compose down

compose-ps:
	docker-compose ps

compose-dev:
	docker-compose exec node -u root node npm run dev
