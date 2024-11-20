USER_ID=$(shell id -u)

DC = @USER_ID=$(USER_ID) docker compose
DC_RUN = ${DC} run --rm php83-fpm
DC_EXEC = ${DC} exec php83-fpm

PHONY: help
.DEFAULT_GOAL := help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: down build install up db-create db-dump fixtures-load success-message console ## Initialize environment

build: ## Build services.
	${DC} build $(c)

up: ## Create and start services.
	${DC} up -d $(c)

stop: ## Stop services.
	${DC} stop $(c)

start: ## Start services.
	${DC} start $(c)

down: ## Stop and remove containers and volumes.
	${DC} down -v $(c)

restart: stop start ## Restart services.

console: ## Login in console.
	${DC_EXEC} /bin/bash

install: ## Install dependencies without running the whole application.
	${DC_RUN} composer install

db-create: ## Create database if not exist.
	${DC_RUN} bin/console doctrine:database:create --if-not-exists

db-dump:
	${DC_RUN} bin/console d:s:u --force

fixtures-load:	## Load fixtures for Products and Coupons entities.
	${DC_RUN} bin/console doctrine:fixtures:load --append

success-message:
	@echo "You can now access the API at http://localhost:8337/api/doc"
	@echo "Good luck! 🚀"