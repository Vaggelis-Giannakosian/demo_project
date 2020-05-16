## Installation of Demo App

- execute: composer install
- create .env by copying .env.example
- set mailtrap credentials on .env
- execute: php artisan key:generate if there is no APP_KEY on .env file

##Starting server

- execute: php artisan serve

##Run tests
- execute: vendor/bin/phpunit
