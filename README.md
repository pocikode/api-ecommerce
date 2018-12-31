
# eCommerce Rest API 

<p align="center">
<a href="https://api-simple-chat.herokuapp.com"><img src="https://travis-ci.org/joemccann/dillinger.svg?branch=master" alt="Build Status"></a>
<a href="https://api-simple-chat.herokuapp.com"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

### Requirements
-   PHP >= 7.1.3
-   Composer
-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Mbstring PHP Extension

### Installation 
```sh
$ git clone https://github.com/pocikode/simple-chat.git
$ cd simple-chat
$ cp .env.example .env
```

Open your favourite text editor.

Open .env file, edit with your database and other services credentials.

```sh
$ composer install
$ php artisan migrate
$ php artisan db:seed
$ php -S localhost:8000 -t public
```

Open your browser, goto **http://localhost:8000**
