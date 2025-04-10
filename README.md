# Laravel Todo App

A simple Todo application built with Laravel 11 and Vue 3.

## Setup

1.  Clone the repository.
2.  Copy `.env.example` to `.env` and configure your database connection (e.g., MySQL, PostgreSQL, or use the default SQLite).
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
3.  Install PHP dependencies:
    ```bash
    composer install
    ```
4.  Run database migrations:
    ```bash
    php artisan migrate
    ```
5.  Install Node.js dependencies:
    ```bash
    npm install
    ```
6.  Build frontend assets:
    ```bash
    npm run build
    ```
7.  (Optional) Seed the database:
    ```bash
    php artisan db:seed
    ```

## Running Locally

*   Start the development server:
    ```bash
    php artisan serve
    ```
*   Start the Vite development server (for hot module replacement):
    ```bash
    npm run dev
    ```

## Running Tests

*   Configure your testing environment in `phpunit.xml` (defaults to in-memory SQLite).
*   Run tests:
    ```bash
    php artisan test
    ```

*(Note: There are currently known issues with database state isolation in tests causing some API tests to fail. See `todo.md` for details.)*
