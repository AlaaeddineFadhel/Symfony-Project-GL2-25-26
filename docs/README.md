# Alumini Symfony Project

Brief README for developers and maintainers.

## Overview
This is the Alumini (Alumni) platform built with Symfony. It provides user registration/login, profile management, a feed with posts, job listings, and recommendations.

Core technologies
- PHP 8.5+ (tested with 8.5.4)
- Symfony 7.x (7.4.12 observed)
- Doctrine ORM + Migrations
- MySQL / MariaDB (8.x tested)
- Twig templates, Bootstrap for UI

## Requirements
- PHP 8.1+ (8.5 recommended)
- Composer
- MySQL 8+ (or compatible)
- Node/npm if rebuilding frontend assets (not required for dev server using public/assets copies)

## Quick Setup (development)
1. Clone the repo

```bash
git clone <repo-url>
cd Symfony-Project-GL2-25-26
```

2. Install PHP dependencies

```bash
composer install
```

3. Copy environment file and set `DATABASE_URL` in `.env.local`

```bash
cp .env.example .env.local
# edit .env.local and set DATABASE_URL, e.g.:
# DATABASE_URL="mysql://root:password@127.0.0.1:3306/gg?serverVersion=8.0.32&charset=utf8mb4"
```

4. Create the database and apply migrations

```bash
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
```

5. (Optional) If assets are missing in `public/assets`, copy or build them. For quick dev, `public/assets` already contains CSS/JS copies.

6. Clear cache and run the dev server

```bash
php bin/console cache:clear --no-warmup
php -S 127.0.0.1:8001 -t public public/index.php
# or use Symfony local server if available:
# symfony server:start
```

Open: http://127.0.0.1:8001/

## Common Commands
- Clear cache: `php bin/console cache:clear --no-warmup`
- List routes: `php bin/console debug:router`
- Migrate DB: `php bin/console doctrine:migrations:migrate`
- Create DB: `php bin/console doctrine:database:create --if-not-exists`
- Twig lint: `php bin/console lint:twig templates`

## Tests
The project contains PHPUnit bootstrap. Run:

```bash
./bin/phpunit
```

## Dev notes & gotchas
- Windows is case-insensitive: avoid having files whose names differ only by case (e.g., `PostController.php` vs `Postcontroller.php`). This caused autoload/routing confusion earlier.
- Routes that are POST-only will return 405 for GET requests (e.g., `app_post_create`). Either provide a GET route for the form or open forms through modals that submit to the POST endpoint.
- If you see Twig error "Unable to generate a URL for the named route 'app_contact'" ensure `ContactController` is present and the route exists (run `php bin/console debug:router app_contact`).

## Branches
- `main` — primary development branch in this workspace
- `backup-before-revert-YYYYMMDD-HHMMSS` — automatic backups created during merge/restore operations
- `ready-php` — snapshot branch pushed with current working changes

## Troubleshooting UI / CSS missing
- The app loads CSS from `public/assets/styles/*.css`. If UI looks unstyled, check that `public/assets/styles` contains `base.css`, `main.css`, and any page-specific CSS.
- `templates/base.html.twig` includes `styles/base.css` and `styles/main.css`. Ensure these files exist and are readable by the server.

## Contribution
- Create feature branches off `main`, run tests and linting, open a PR when ready.

