# How to get it working:

* Adjust tasks/.env
```
  DB_CONNECTION=mysql
  DB_HOST=mysql
  DB_PORT=3306
  DB_DATABASE=png
  DB_USERNAME=png
  DB_PASSWORD=png
```
## Login to container and run composer install and migrate
* `docker exec -it mend-webserver /bin/bash`
* Run `composer install`
* Run `php artisan migrate`

## New Node container to run NPM commands from for installing frontend packages
* * NPM Install `docker-compose run --rm npm i`
* * NPM Build `docker-compose run --rm npm run dev`

Once that's complete, the app should be viewable at http://localhost. You can add and delete a task. I was working on editing, but there's some more UI that needs to happen to accomplish that. The backend API supports it though. The routes below are active and working.

* Routes:
``` 
    GET     /api/v1/task       (Index)
    POST    /api/v1/task       (Create)
    GET     /api/v1/task/{id}  (Read)
    PUT     /api/v1/task/{id}  (Update)
    DELETE  /api/v1/task/{id}  (Delete)
```
