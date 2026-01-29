# Automated Code Review

This directory contains GitHub Actions workflows that automatically review code whenever a new branch is pushed or a pull request is created.

## Code Review Workflow

**File:** `workflows/code-review.yml`

### When it runs

- **On push:** Triggers for any branch except `master` and `main`
- **On pull request:** Triggers for PRs targeting `master` or `main` branches

### What it checks

1. **Code Style (Laravel Pint)**
   - Checks if code follows Laravel's coding standards
   - Uses PSR-12 coding style
   - Must pass for workflow to succeed

2. **Static Analysis (Larastan/PHPStan)**
   - Performs static code analysis at level 5
   - Checks for type errors, undefined methods, and other issues
   - Configured via `phpstan.neon` in project root

3. **Security Audit**
   - Runs `composer audit` to check for known security vulnerabilities
   - Checks all dependencies for security advisories

4. **Tests (PHPUnit)**
   - Runs all unit and feature tests
   - Uses PostgreSQL 15 service container for database tests
   - Tests must pass for workflow to succeed

### Local Testing

Before pushing your branch, you can run the same checks locally:

```bash
# Run all checks at once
make code_review

# Or run individual checks
make lint_check  # Check code style
make stan        # Run static analysis
make audit       # Check security vulnerabilities
make test        # Run tests
```

### Fixing Issues

If the code review fails:

1. Check the workflow logs in GitHub Actions tab
2. Fix issues locally using:
   - `make lint` - Automatically fix code style issues
   - Review and fix static analysis errors manually
   - `composer update` - Update vulnerable packages
   - Fix failing tests

### Configuration Files

- `.github/workflows/code-review.yml` - GitHub Actions workflow
- `phpstan.neon` - PHPStan static analysis configuration
- `pint.json` - Laravel Pint configuration (optional, uses defaults)
