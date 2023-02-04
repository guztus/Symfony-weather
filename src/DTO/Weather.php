<?php

namespace App\DTO;

class Weather
{
    private string $city;
    private ?float $temperature;
    private ?int $windSpeed;

    public function __construct(string $city, ?float $temperature, ?int $windSpeed)
    {
        $this->city = $city;
        $this->temperature = $temperature;
        $this->windSpeed = $windSpeed;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function getWindSpeed(): ?int
    {
        return $this->windSpeed;
    }
}