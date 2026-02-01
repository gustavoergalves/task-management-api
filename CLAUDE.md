# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Laravel 10 REST API for task management. Runs entirely in Docker (PHP 8.2-FPM, Nginx, PostgreSQL 15). API available at `http://localhost:8080`.

## Commands

All commands run through Docker via Makefile:

```bash
make build              # Build Docker containers
make up                 # Start containers
make down               # Stop containers
make init               # Full setup: composer install + key generate + migrate with seed

make test               # Run all tests (Unit + Feature)
make lint               # Auto-fix code style (Laravel Pint / PSR-12)
make lint_check         # Check code style without fixing
make stan               # Run PHPStan static analysis (level 5)
make audit              # Check dependencies for security vulnerabilities
make code_review        # Run all checks: lint_check → stan → audit → test
```

### Running specific tests

```bash
docker-compose exec app php artisan test --filter TestClassName
docker-compose exec app php artisan test --filter test_method_name
docker-compose exec app php artisan test --testsuite=Unit
docker-compose exec app php artisan test --testsuite=Feature
```

## Architecture

**Request flow:** Route → Single-Action Controller (`__invoke()`) → FormRequest (validation) → Service → Repository → Model

**Response flow:** Model → DTO (Spatie Laravel Data) → Service → Controller → JSON Response

### Layer locations

- **Routes:** `routes/api.php`
- **Controllers:** `app/Http/Controllers/Task/` — one controller per action, each with `__invoke()`
- **Form Requests:** `app/Http/Requests/Task/` — validation rules
- **Services:** `app/Services/Task/` — business logic, return DTOs not models
- **Repositories:** `app/Repositories/` — data access; contracts in `app/Repositories/Contracts/`
- **DTOs:** `app/Data/` — Spatie Laravel Data classes with `fromModel()` and `fromRequest()` factory methods
- **Enums:** `app/Enums/` — `TaskStatusEnum` (pending, in_progress, completed), `TaskPriorityEnum` (low, medium, high)

### Key patterns

- **Dependency injection** bound in `TaskServiceProvider` (`TaskRepositoryInterface` → `TaskRepository`)
- **`declare(strict_types=1)`** in all application files
- **Database uses snake_case** (`due_date`), **API uses camelCase** (`dueDate`)
- **Tests:** Feature tests in `tests/Feature/Http/Controllers/`, Unit tests in `tests/Unit/Services/`. Feature tests use in-memory SQLite (`phpunit.xml`). Test naming: `test_when_[condition]_then_it_should_[expected_behavior]()`

## API Endpoints

All under `/api/tasks`:

| Method | Path | Controller | Status |
|--------|------|-----------|--------|
| POST | `/api/tasks` | CreateTaskController | 201 |
| GET | `/api/tasks` | ListTasksController | 200 |
| GET | `/api/tasks/statistics` | GetTaskStatisticsController | 200 |
| GET | `/api/tasks/{task}` | FindByIdTaskController | 200 |
| PATCH | `/api/tasks/{task}` | UpdateTaskController | 200 |
| DELETE | `/api/tasks/{task}` | DeleteTaskController | 204 |

## CI/CD

GitHub Actions workflow (`.github/workflows/code-review.yml`) runs on push (non-main branches) and PRs to main/master: code style check → static analysis → security audit → tests.
