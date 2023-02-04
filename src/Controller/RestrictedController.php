<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestrictedController extends AbstractController
{
    #[Route('/api/restricted', name: 'app_restricted')]
    public function index(): Response
    {
        return $this->render('restricted/index.html.twig', [
            'controller_name' => 'RestrictedController',
        ]);
    }
}
