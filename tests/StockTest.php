<?php

namespace App\Tests;

use App\Message\WeatherRequestMessage;
use App\MessageHandler\WeatherRequestHandler;
use App\WeatherAPI\OpenWeatherAPI;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class StockTest extends TestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testStock()
    {
//    test the APIController
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid weather type');

        $messageBus = $this->createMock(MessageBusInterface::class);
        $messageBus->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(new WeatherRequestMessage('city', 'type')))
            ->willReturn(new Envelope(new WeatherRequestMessage('city', 'type'), [new HandledStamp('result', 'handler')]));

        $weatherRequestHandler = new WeatherRequestHandler(new OpenWeatherAPI($this->createMock(HttpClientInterface::class)));
        $result = $weatherRequestHandler(new WeatherRequestMessage('city', 'type'));
        $result = $messageBus
            ->dispatch(new WeatherRequestMessage('Riga', 'now'))
            ->last(HandledStamp::class)
            ->getResult();
        dd($result);
    }
}