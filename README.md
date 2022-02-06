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
-   Go to directory ./sc-admin
-   Run `sudo chmod -R 777 storage`
-   Run `sudo chmod -R 777 bootstrap/cache`
-   Run `composer install`
-   Copy the `.env.example` file to `.env`
-   Provide the Database Connection (or other appropriate information)
-   Run `php artisan migrate --seed`
-   Run `npm install`
-   Run `npm run dev`
-   Set the SC2 Admin Tool **URL**

## Staging URL

[SC Admin Webtool (Development Copy)](https://dev-admin.smartchartsfx.com/login)

## Default Login Credentials

### Super Admin
**Email:** sc_superadmin@smartchartsfx.com 

**Password:** SC!2020SuperAdmin 

### Admin
**Email:** sc_admin@smartchartsfx.com

**Password:** SmartCharts!2020