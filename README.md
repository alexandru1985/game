## About Project

Tools: PHP8, PHPUnit, Docker

## Project Installation 

Copy project from GitHub 

```
git clone https://github.com/alexandru1985/game.git
```

In the root folder of project, named game, run below commands one by one 

```
cd docker <br>
docker-compose build <br>
docker-compose up -d 
```

Then login on php container and install composer

```
docker exec -it game-php-fpm /bin/sh <br>
composer install
```

Then for project running use below link

```
http://localhost
```

## Unit Testing

Run inside php container below command

```
php ./vendor/bin/phpunit
```
In the root folder of project, named system_manager, run commands one by one
