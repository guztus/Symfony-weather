<?php

namespace App\WeatherAPI;

use App\DTO\GeographicCoordinates;
use App\DTO\Weather;

interface WeatherAPIInterface
{
    public function getWeatherNow(string $city): Weather;
    public function getWeatherForecast(string $city): Weather;
    public function getLocation(string $city): GeographicCoordinates;
}