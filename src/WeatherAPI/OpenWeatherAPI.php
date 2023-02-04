<?php

namespace App\WeatherAPI;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\DTO\Weather;
use App\DTO\GeographicCoordinates;

class OpenWeatherAPI implements WeatherAPIInterface
{
    private HttpClientInterface $client;
    private const API_URL = "https://api.openweathermap.org/";
    private string $apiKey = '31e0ead42aa2ee1551c65f88bef6b2c6';

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getWeatherForecast(string $city): Weather
    {
        $coordinates = $this->getLocation($city);
        try {
            $response = $this->client->request(
                'GET',
                self::API_URL . "/data/2.5/forecast",
                [
                    'query' =>
                        [
                            'lat' => $coordinates->getLatitude(),
                            'lon' => $coordinates->getLongitude(),
                            'appid' => $this->apiKey,
                        ]
                ]
            );
            $response = $response->toArray();
        } catch (\Exception) {
            return new Weather($city, null, null);
        }

        $temp = 0;
        $wind = 0;
        foreach ($response['list'] as $item) {
            $temp += ($item['main']['temp']);
            $wind += ($item['wind']['speed']);
        }
        $temp = $temp / count($response['list']);
        $wind = $wind / count($response['list']);

        return new Weather($city, $temp, $wind);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getWeatherNow(string $city): Weather
    {
        $coordinates = $this->getLocation($city);
        try {
            $response = $this->client->request(
                'GET',
                self::API_URL . "/data/2.5/weather",
                [
                    'query' =>
                        [
                            'lat' => $coordinates->getLatitude(),
                            'lon' => $coordinates->getLongitude(),
                            'appid' => $this->apiKey,
                        ]
                ]
            );
            $response = $response->toArray();
        } catch (\Exception) {
            return new Weather($city, null, null);
        }

        $temp = $response['main']['temp'];
        $wind = $response['wind']['speed'];
        return new Weather($city, $temp, $wind);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getLocation(string $city): GeographicCoordinates
    {
        try {
            $response = $this->client->request(
                'GET',
                self::API_URL . "/geo/1.0/direct",
                [
                    'query' =>
                        [
                            'q' => $city,
                            'appid' => $this->apiKey,
                        ]
                ]
            );
            $response = $response->toArray();
        } catch (\Exception) {
            return new GeographicCoordinates(null, null);
        }
        return new GeographicCoordinates($response[0]['lat'], $response[0]['lon']);
    }
}