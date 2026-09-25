# SchoolAdmin

SchoolAdmin is a school management web application built with Laravel. It brings an institution's administrative operations, academic tracking, and tuition management together in one place.

## Features

- **Admissions and students**: academic years and admission periods, applications, student records, enrollment counts, ID cards, certificates, discipline, and transcripts.
- **Teachers and staff**: teacher and staff records, subject assignments, availability, and disciplinary tracking.
- **Academic structure**: cycles, levels, programs, specializations, teaching units, subjects, syllabi, and courses.
- **Timetables**: course scheduling and timetable viewing.
- **Assessments and results**: assessments, grade entry, report cards, exam records, and semester transcripts.
- **Tuition and payments**: fees, payments, receipts, accounts, and payment-status reports.
- **Administration**: users, groups and permissions, menus, activity history, institution details, organization chart, and settings.
- **Documents**: PDF document and report generation, as well as image and avatar management.
- **Dedicated workspaces**: features available to teachers and students according to their accounts and permissions.

This feature overview is based on the project's routes and controllers. The API currently defined in `routes/api.php` is limited to retrieving the authenticated user's profile through Sanctum.

## Technologies and Libraries

### Backend

- PHP `^7.3 | ^8.0` and Laravel `^8.75` (the version locked in the repository is Laravel 8.82).
- MySQL is the default configured database; Laravel also includes configurations for SQLite, PostgreSQL, and SQL Server.
- `encore/laravel-admin` for the administration interface.
- `laravel/sanctum` for token-based API authentication and `laravel/ui` for authentication scaffolding.
- `barryvdh/laravel-dompdf` and `elibyy/tcpdf-laravel` for PDF exports.
- `intervention/image` for image processing.
- `guzzlehttp/guzzle` for HTTP requests and `fruitcake/laravel-cors` for CORS support.

### Frontend and Asset Compilation

- Vue.js 2, Bootstrap 5, and Sass.
- Laravel Mix 6, Webpack, and PostCSS to compile assets from `resources/` into `public/`.
- Axios, Lodash, and Popper.js.

PHP dependency versions are recorded in `composer.lock`. The repository does not include a `package-lock.json`, so JavaScript dependency versions are not locked.

## Local Installation

### Requirements

- A PHP version compatible with the constraints in `composer.json`, Composer, and the PHP extensions required by Laravel, including PDO with the driver for your database.
- MySQL or MariaDB is recommended. Node.js and npm are needed to compile frontend assets.

### Setup

```bash
git clone <URL_DU_DEPOT>
cd schooladmin
composer install
cp .env.example .env
```

Set the application name and your database `DB_*` values in `.env`. Create the database, then run:

```bash
php artisan key:generate
php artisan migrate
npm install
npm run dev
php artisan storage:link
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`. To compile optimized assets, run `npm run production`.

## Deployment

1. Prepare a server with a compatible PHP version, Composer, PHP-FPM (or an equivalent PHP server), a MySQL/MariaDB database, and Apache or Nginx. Set the site's document root to the project's `public/` directory.
2. Check out the code and install the production dependencies:

	```bash
	composer install --no-dev --prefer-dist --optimize-autoloader
	```

3. Create `.env` from `.env.example` and configure at least `APP_NAME`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, and the `DB_*` variables. Never commit this file or secrets to Git.
4. Create the database and a user with the required privileges, then initialize the application:

	```bash
	php artisan key:generate
	php artisan migrate --force
	php artisan storage:link
	php artisan config:cache
	php artisan view:cache
	```

	Run `key:generate` only on the initial installation. Keep the same `APP_KEY` for subsequent deployments.
5. Compile frontend assets on the build machine or server before release:

	```bash
	npm install
	npm run production
	```

	Deploy the generated files in `public/` with the application.
6. Grant the PHP process write access to `storage/` and `bootstrap/cache/`, enable HTTPS, and check `storage/logs/` after the first startup.

### Demo Data Warning

The default seeder (`php artisan db:seed`) calls `DataSeeder`, which truncates several tables before inserting initial data. **Do not run this command against a database containing data you need to keep.** Review and adapt the seeder before using it, especially in production.

## Tests

PHPUnit tests are configured in `phpunit.xml`. Run them with:

```bash
vendor/bin/phpunit
```

## License

The project declares the MIT license in `composer.json`.
