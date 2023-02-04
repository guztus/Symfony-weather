<?php

namespace App\MessageHandler;

use App\DTO\Weather;
use App\Message\WeatherRequestMessage;
use App\WeatherAPI\OpenWeatherAPI;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsMessageHandler]
final class WeatherRequestHandler
{
    private OpenWeatherAPI $weatherAPI;

    public function __construct(OpenWeatherAPI $weatherAPI)
    {
        $this->weatherAPI = $weatherAPI;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception
     */
    public function __invoke(WeatherRequestMessage $message): Weather
    {
        if ($message->getType() === 'now') {
            return $this->weatherAPI->getWeatherNow($message->getCity());
        }
        if ($message->getType() === 'forecast-average') {
            return $this->weatherAPI->getWeatherForecast($message->getCity());
        }
        throw new Exception('Invalid weather type');
    }
}
