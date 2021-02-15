![Heroku](https://heroku-badge.herokuapp.com/?app=heroku-badge)
[![Build Status](https://www.travis-ci.com/VenzDev/notes-rest-api.svg?token=AjcqyYboxEzhAQTF6Zfp&branch=master)](https://www.travis-ci.com/VenzDev/notes-rest-api)
## note-rest-api

### Installation 
You’ll need to have PHP 8, Composer and MySQL on your local machine to run this project.

Clone this repository and switch to the repo folder

    cd notes-rest-api
    
Install all the dependencies using composer

    composer install
    
Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate
    
Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate
    php artisan migrate --database=mysql_testing
    
Start the local development server

    php artisan serve

### Testing

Run this command to execute integration tests

    php artisan test
