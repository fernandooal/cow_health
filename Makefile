SHELL := /bin/bash

# Define as variáveis de imagem
IMAGE_NAME_MYSQL := mysql/mysql-server:8.0
IMAGE_NAME_PHPMYADMIN := phpmyadmin

# Define as variáveis de projeto
PROJECT_NAME := cow_health
CONTAINER_NAME_MYSQL := cow_health_app_mysql
CONTAINER_NAME_PHP := cow_health_app_php

# Variáveis de ambiente do MySQL
MYSQL_ROOT_PASSWORD := password
MYSQL_DATABASE := app_db
MYSQL_USER := sail
MYSQL_PASSWORD := password


# Alvo padrão: build e up
all: build up

# Alvo para construir as imagens
build:
	docker compose build

# Alvo para iniciar os serviços
up:
	docker compose up -d

# Alvo para parar e remover os serviços
down:
	docker compose down

# Alvo para parar os serviços
stop:
	docker compose stop
# Alvo para reiniciar todos os containers
restart:
	docker compose restart
# Alvo para parar, remover e limpar imagens e volumes
clean: down
	docker system prune -af
	docker volume prune -f

# Alvo para apenas construir as imagens
rebuild: clean build

# Alvo para exibir logs gerais de todos os serviços
logs:
	docker compose logs -f

# Alvo para exibir logs do serviço PHP
logs-php:
	docker compose logs -f php

# Alvo para exibir logs do serviço Worker
#logs-worker:
#	sudo docker compose logs -f worker

# Alvo para exibir logs do serviço MySQL
logs-mysql:
	docker compose logs -f mysql

# Alvo para exibir logs do serviço phpMyAdmin
logs-phpmyadmin:
	docker compose logs -f phpmyadmin

# Alvo para mostrar o status dos containers
status:
	docker compose ps

# Alvo para mostrar todos os containers do docker incluindo os que não são do projeto
psa:
	docker ps
ps:
	docker compose ps -a

# Alvo para mostrar todos os containers do docker que são do projeto
comps:
	docker compose ps -a

# Alvo para conectar ao container PHP usando bash
p:
	docker exec -it $(CONTAINER_NAME_PHP) bash

# Alvo para conectar ao container MySQL usando o cliente MySQL
mysql:
	docker exec -it $(CONTAINER_NAME_MYSQL) mysql -u${MYSQL_USER} -p${MYSQL_PASSWORD}

root-mysql:
	docker exec -it $(CONTAINER_NAME_MYSQL) mysql -u root -p

# Alvo para realizar as permissões de pasta do projeto
perm:
	sudo chmod -R 777 ../$(PROJECT_NAME)/
