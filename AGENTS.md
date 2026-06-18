# Repository Guidelines

## Project Structure & Module Organization

This is a Laravel 12 application with a Flutter client subproject. Core PHP code lives in `app/`, with HTTP controllers under `app/Http/Controllers`, middleware in `app/Http/Middleware`, Livewire components in `app/Livewire`, and Eloquent models in `app/Models`. Routes are split between `routes/web.php`, `routes/api.php`, and `routes/console.php`. Blade views and Markdown content are in `resources/views` and `resources/markdown`; Vite-managed frontend entry points are `resources/js/app.js` and `resources/css/app.css`. Database migrations, factories, and seeders are in `database/`. Tests are organized as `tests/Feature` and `tests/Unit`. Docker assets are in `Dockerfile`, `docker/`, and `docker-compose.prod.yml`. The Flutter client lives in `skillconnect_mobile/`, with app source under `skillconnect_mobile/lib/src`.

## Build, Test, and Development Commands

- `composer install` installs PHP dependencies.
- `npm install` installs Vite/frontend dependencies.
- `composer run dev` starts Laravel, the queue listener, and Vite together for local development.
- `npm run dev` runs only the Vite development server.
- `npm run build` builds production frontend assets.
- `composer run test` clears config and runs the Laravel test suite.
- `php artisan migrate --seed` applies migrations and seeds local data when needed.
- `cd skillconnect_mobile && flutter pub get` installs Flutter dependencies.
- `cd skillconnect_mobile && flutter analyze` runs Dart static analysis.
- `cd skillconnect_mobile && flutter test` runs Flutter tests.

## Coding Style & Naming Conventions

Follow Laravel conventions and PSR-4 namespaces. Use 4-space indentation for PHP and Blade control structures. Name controllers by feature and role, such as `PaymentController` or `Admin/CourseController`; name Eloquent models in singular StudlyCase. Keep Blade components in `resources/views/components` and prefer kebab-case view filenames. Use Laravel Pint for PHP formatting: `./vendor/bin/pint`.

## Testing Guidelines

PHPUnit is configured in `phpunit.xml`; tests run against in-memory SQLite with array cache, mail, and session drivers. Place endpoint, authentication, and workflow coverage in `tests/Feature`; reserve `tests/Unit` for isolated logic. Name tests after the behavior being verified, for example `ApiPaymentTest.php` or `UpdatePasswordTest.php`. Run `composer run test` before opening a pull request.

## Commit & Pull Request Guidelines

Recent commits use short, imperative summaries such as `update github`, `fix update docker`, and `testing deploy`. Keep commits focused and use a clearer action phrase when possible, for example `fix payment upload validation`. Pull requests should include a concise description, affected routes or screens, test results, linked issues, and screenshots for Blade or Livewire UI changes. Note any migration, seed, or deployment impacts explicitly.

## Security & Configuration Tips

Do not commit `.env`, generated keys, logs, or uploaded files. Keep secrets in environment variables and verify storage links, queue settings, and mail configuration per environment. For API changes, review Sanctum token permissions and update related feature tests.
