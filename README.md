## Environment
Run `docker-compose build` and `docker-compose up -d` in the project folder, then use
`docker exec -it <name_of_php_container> /bin/bash` to enter the PHP container for composer install, import database and running the unit-test.

## Dependencies
In php container;

Run `composer install`

## Import sql data
In php container; 

Run `php import_sql.php`

## Export CSV

Start and End dates of request are set on index.php. Calling the index link above, will export the file.

[GET] `http://localhost:8080`

## Unit Test

In php container;

`./vendor/bin/phpunit Tests`