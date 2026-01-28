# AGENTS.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Common Development Commands

This project runs entirely in Docker containers. All commands should be executed through the Makefile:

- `make build` - Build Docker containers
- `make up` - Start containers in detached mode
- `make down` - Stop and remove containers
- `make init` - Initialize application (composer install, generate app key, run migrations with seed)
- `make install` - Install composer dependencies
- `make test` - Run all PHPUnit tests (both Unit and Feature)
- `make php_shell` - Access PHP container shell
- `make migrate` - Run pending migrations
- `make migrate_rollback` - Rollback last migration batch
- `make migration` - Create new migration (interactive)
- `make clear_caches` - Clear Laravel caches (cache, config, route)
- `make lint` - Fix code style issues with Laravel Pint
- `make lint_check` - Check code style without fixing
- `make stan` - Run PHPStan static analysis
- `make audit` - Check for security vulnerabilities
- `make code_review` - Run all code review checks (lint, stan, audit, tests)

API is available at: `http://localhost:8080`
Database runs on PostgreSQL (port 5432 externally, configurable via `.env`)

### Running Specific Tests

To run a specific test file or test method, use:
```bash
docker-compose exec app php artisan test --filter TestClassName
docker-compose exec app php artisan test --filter test_method_name
```

To run only Unit tests:
```bash
docker-compose exec app php artisan test --testsuite=Unit
```

To run only Feature tests:
```bash
docker-compose exec app php artisan test --testsuite=Feature
```

## Architecture

This is a Laravel 10 API-only application following clean architecture principles with Repository and Service patterns.

### Layered Architecture

**Request Flow:** Route → Controller → Service → Repository → Model → Database

1. **Routes** (`routes/api.php`) - Define API endpoints
2. **Controllers** (`app/Http/Controllers/Task/`) - Single-action controllers using `__invoke()`, handle HTTP concerns
3. **Form Requests** (`app/Http/Requests/Task/`) - Handle validation rules
4. **Services** (`app/Services/Task/`) - Contain business logic, orchestrate repositories
5. **Repositories** (`app/Repositories/`) - Data access layer, interact with models
6. **Repository Interfaces** (`app/Repositories/Contracts/`) - Define repository contracts
7. **Data Transfer Objects** (`app/Data/`) - Use Spatie Laravel Data for type-safe data transfer between layers
8. **Models** (`app/Models/`) - Eloquent models representing database tables
9. **Enums** (`app/Enums/`) - PHP 8.1+ enums for fixed value sets (TaskStatusEnum, TaskPriorityEnum)

### Key Patterns

- **Single Action Controllers**: Each controller handles one action via `__invoke()` method
- **Repository Pattern**: All database interactions go through repository interfaces, bound in `TaskServiceProvider`
- **Service Layer**: Services contain business logic and return DTOs, not models
- **Data Transfer Objects**: Spatie Laravel Data package used for type-safe DTOs with static factory methods:
  - `TaskData::fromModel(Task $task)` - Convert model to DTO
  - `TaskData::fromRequest(CreateUpdateTaskRequest $request)` - Convert request to DTO
- **Dependency Injection**: Constructor injection used throughout (controllers, services, repositories)
- **Type Safety**: `declare(strict_types=1)` at the top of all files

### Service Provider Bindings

`TaskServiceProvider` binds repository interfaces to implementations:
```php
$this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
```

### Task Entity

Task attributes:
- `status`: pending | in_progress | completed (enum)
- `priority`: low | medium | high (enum)
- `title`: string (max 100 chars, required)
- `description`: string (max 500 chars, nullable)
- `dueDate`: date in Y-m-d format (nullable)

Database uses snake_case (`due_date`, `created_at`), API uses camelCase (`dueDate`, `createdAt`).

### Testing Strategy

- **Feature tests** (`tests/Feature/Http/Controllers/`): Test complete HTTP request/response cycles
- **Unit tests** (`tests/Unit/Services/`): Test service layer with mocked repositories
- Use `$this->mock()` for creating mocks in unit tests
- Feature tests use in-memory SQLite database (configured in `phpunit.xml`)
- Naming convention: `test_when_[condition]_then_it_should_[expected_behavior]()`

### Database

- PostgreSQL 15 as primary database
- SQLite in-memory for testing
- Migrations in `database/migrations/`
- Enum columns use PHP enum values via helper method: `TaskStatusEnum::values()`
- Model casts handle enum conversion automatically
