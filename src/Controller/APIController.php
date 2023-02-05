<?php

namespace App\Controller;

use App\Message\WeatherRequestMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    #[Route('/api/weather/{city}/{type}', name: 'weather', methods: 'GET')]
    public function weatherNow(string $city, string $type, MessageBusInterface $bus): JsonResponse
    {
        if (!in_array($type, ['now', 'forecast-average'])) {
            return new JsonResponse(['error' => 'Invalid weather type'], Response::HTTP_BAD_REQUEST);
        }

        $result = $bus
            ->dispatch(new WeatherRequestMessage($city, $type))
            ->last(HandledStamp::class)
            ->getResult();

        return new JsonResponse([
            'city' => $result->getCity(),
            'temperature' => $result->getTemperature(),
            'wind_speed' => $result->getWindSpeed(),
        ]);
    }
}
