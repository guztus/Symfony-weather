# Symfony - Weather fetcher 

## Table of contents

* [General info](#general-info)
* [Demonstration GIFs](#demonstration-gifs)
* [Used Technologies](#used-technologies)
* [Setup](#setup)

## General info

This project displays weather data and implements JWT token authentication with refresh token.

Authenticated users can fetch the temperature and wind speed:
* Current
* 5 day forecast average

## Demonstration GIFs

<div style="text-align: center">
    <h3>Registering and Logging in</h3>
    <p align="center">
        <img src="/GIF_1.gif"  width="95%" alt="animated-demo" /><br>
    </p>
    <h3>Fetching the weather</h3>
    <p align="center">
        <img src="/GIF_2.gif" width="95%" alt="animated-demo" /><br>
    </p>
</div>

## Used Technologies

* Symfony `6.1`
* PHP `8.0`
* SQLite `3`
* Composer `2.4`

## Setup

To install this project on your local machine, follow these steps:

##### Getting the workplace ready
1. Clone this repository - `git clone https://github.com/guztus/Symfony-weather`
2. Install composer dependencies - `composer install`
3. Rename the ".env.example" file to ".env" and edit the JWT_PASSPHRASE in .env
4. Generate a keypair - `symfony console lexik:jwt:generate-keypair`
5. Set the <a href="https://home.openweathermap.org/api_keys">OpenWeatherMap (free)</a> API key - `symfony console secrets:set OPENWEATHERMAP_API_KEY`
6. Set up the database - `php bin/console doctrine:database:create`
7. Run the migrations - `php bin/console doctrine:migrations:migrate`
8. To run the project, enter `symfony serve`
