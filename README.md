# e-learning

## Server Requirements
-   PHP >= 7.2.5
-   MySQL >= 14.x
-   Node >=14.9.0
-   BCMath PHP Extension
-   Ctype PHP Extension
-   Fileinfo PHP extension
-   JSON PHP Extension
-   Mbstring PHP Extension
-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension

## Installation
-   Checkout from git
-   Go to directory ./e-learning/admin
-   Run `sudo chmod -R 777 storage`
-   Run `sudo chmod -R 777 bootstrap/cache`
-   Run `composer install`
-   Copy the `.env.example` file to `.env`
-   Provide the Database Connection (or other appropriate information)
-   Run `php artisan migrate --seed`
-   Run `php artisan passport: install`

check node version, if not v14.9.0
    Run `nvm use v14.9.0`
-   Run `npm install`
-   Run `npm run dev`
-   Set the e-learning Admin Tool **URL**

## Staging URL

## Default Login Credentials

### Super Admin
**Email:** mFWtYzXQB4@gmail.com

**Password:** password

### Admin
**Email:** 

**Password:** 