## Laravel 5.6 Blog API

Simple blog API built with Laravel 5.6 utilising the new API resource tools, 
Passport was used to handle authentication using OAuth2 which uses JWT token internally.
Includes a full suite of Codeception API tests for all endpoints.

Attempted to use Behat but found the main Laravel integration package lacked support for Laravel 5.6 at this time due to this [issue](https://github.com/laracasts/Behat-Laravel-Extension/issues/78)

### Installation

1. `git clone https://github.com/chriscornford/laravel-blog-api.git`
2. `composer install`
3. `cp .env.example .env`
4. `php artisan key:generate`
5. Ensure correct database details are in new `.env` file
6. `php artisan migrate`
7. `php artisan passport:install`

Run codeception tests using `vendor/bin/codecept run`

Postman collection export can be found in the base directory.

Packages used:
* `codeception/codeception`
* `laravel/passport`
* `flow/jsonpath`

References:
* https://laravel.com/docs/5.6
* https://laravel.com/docs/5.6/passport
* https://codeception.com/docs/09-Data
