.PHONY: help

help: ## Display all available commands.
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-10s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

install: ## Setup project and install dependencies.
	@cp .env.example .env
	@composer install
	@php artisan key:generate

start: ## Start containers.
	@docker compose up -d

stop: ## Stop containers.
	@docker compose down

migrate: ## Migrate database migrations inside Docker container.
	@docker exec -it Test php artisan migrate

test-db: ## Migrate database migrations and seed data inside Docker container.
	@docker exec -it Test php artisan migrate --seed
