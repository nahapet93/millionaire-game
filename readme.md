## Installation

- Git clone in your computer
- Copy the `.env.example` file to `.env` and put your credentials there
- Run `composer install`
- Run `php artisan migrate`
- Run `php artisan db:seed` (to create an admin user)
- Run `php artisan key:generate`
- Run `php artisan serve` (or make a virtual host and run with apache)

Admin login and password are `admin@gmail.com` / `admin123`

For testing, a database dump with questions and answers is included in the root folder (`millionaire.sql.gz`)