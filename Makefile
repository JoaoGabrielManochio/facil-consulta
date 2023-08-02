up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

test:
	docker-compose exec facil.consulta ./vendor/bin/phpunit $(FILE)