## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)

## General info
This project is api simulator for showing current temperature and 5 day foreacst for particular city
	
## Technologies
Project is created with:
* Laravel version : 8

	
## Setup
To run this project, install it locally:

```
$ cd ../project_directory
$ git clone https://github.com/mladenmladen91/weather.git
$ composer install
$ create .env file and enter name of database you want to use
$ WEATHER_KEY=1213243134dhfdfsf- an example of weather_key in .env file, CACHE_DRIVER=database - setting cache in database
$ php artisan cache:table
$ php artisan migrate
$ php artisan serve