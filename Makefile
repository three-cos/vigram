DOCKER_COMPOSE_FLAGS=-f docker-compose.yml -f docker-compose.override.yml

up:
	docker-compose ${DOCKER_COMPOSE_FLAGS} up -d

down:
	docker-compose ${DOCKER_COMPOSE_FLAGS} down

restart:
	make down
	make up

status:
	docker-compose ${DOCKER_COMPOSE_FLAGS} ps

cli:
	docker-compose ${DOCKER_COMPOSE_FLAGS} exec --user=www-data php-fpm bash || true

logs:
	docker-compose ${DOCKER_COMPOSE_FLAGS} logs -f

docker-config:
	docker-compose ${DOCKER_COMPOSE_FLAGS} config
