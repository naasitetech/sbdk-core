lara-jwt-core
=================

A basic Laravel project with JWT Authentication

## Project Details
- Project : lara-jwt-core
- Version : v1.0
- Author : Nazrul Hanif
- Date Created : 20210531

## Project Contributor
- Developer : [Nazrul Hanif](https://github.com/lordnaz)


## First Timer Setup
This Instruction is for the first timer setup.

1. Install Composer (Make sure to have PHP 7.4 & above - Recommended)
2. Clone this repo to your local
3. Dependency Manager : run `composer install` in your cmd. 
```
$ composer install
```
4. run `php artisan serve` in your cmd go to localhost:8000 or http://127.0.0.1:8000 (default at port 8000 can be change if require)
```
$ php artisan serve
```

## DB Migration

Use this instruction to run existing Migration file.

1. create new DB at MySQL named as medusa (medusa name is default, if you changed to other name, u will need to reconfigure .ENV file)
2. run `php artisan migrate:refresh` in your cmd to re-run all the migration files.
```
$ php artisan migrate:refresh
```

## Faker/Factories

Use this to run some faker data.

1. PHP tinker : run `php artisan tinker` in your cmd. 
```
$ php artisan tinker
```
2. create 5 dummy data of user faker : run `User::factory()->count(5)->create()`
```
$ User::factory()->count(5)->create()
```
3. create 15 dummy data of todo faker : run `Todo::facroty()->count(15)->create()`
```
$ Todo::factory()->count(15)->create()
```


## IMPORTANT! 

If you encounter ERR 500 during serve the project. Follow this instruction!

1. copy .env files : run `cp .env.example .env`.
```
$ cp .env.example .env
```
2. generate key : run `php artisan key:generate`.
```
$ php artisan key:generate
```
3. generate key : run `php artisan jwt:secret`.
```
$ php artisan jwt:secret
```
4. cache clear : run `php artisan cache:clear`.
```
$ php artisan cache:cache
```
5. config cache : run `php artisan config:clear`.
```
$ php artisan config:clear
```
6. serve again : run `php artisan serve`.
```
$ php artisan serve
```

## Support 

For Support & Inquiry kindly contact me at:-

- Click [here](https://github.com/lordnaz) to go to developer profile.
- Or email me at nazrul.workspace@gmail.com