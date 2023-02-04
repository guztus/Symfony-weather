<?php

namespace App\Message;

final class WeatherRequestMessage
{
     private string $city;
    private string $type;

    public function __construct(string $city, string $type)
     {
         $this->city = $city;
         $this->type = $type;
     }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
