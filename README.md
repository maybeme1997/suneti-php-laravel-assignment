# Book app

To set up your local dev environment, follow these steps:

1. Clone the repo
1. Run `cp .env.example .env` to create a local environment file
1. Run `docker-compose up -d` to start the app
1. Run `docker-compose exec app composer install` to install dependencies
1. Run `docker-compose exec app php artisan key:generate` to generate an app key
1. Run `docker-compose exec app php artisan migrate:fresh --seed` to run migrations and seed the database
1. Map `php-laravel-assignment.nl` to localhost or 127.0.0.0 in your hosts file
1. Visit [http://php-laravel-assignment.nl](http://php-laravel-assignment.nl) in your browser
