<?php

namespace App\Controller;

use App\Message\WeatherRequestMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home/{city}/{type}', name: 'weather', methods: 'GET')]
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
            'city' => $result->getCity() ?? 'No data available',
            'temperature' => $result->getTemperature() ?? 'No data available',
            'wind_speed' => $result->getWindSpeed() ?? 'No data available',
        ], Response::HTTP_OK);
    }
}
