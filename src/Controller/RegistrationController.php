<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register_form', methods: 'GET')]
    public function registerForm(): Response
    {
        return $this->render('registration/register.html.twig');
    }

    #[Route('/register', name: 'app_register_post', methods: 'POST')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $request = json_decode($request->getContent(), true);
        if (!isset($request['email']) || !isset($request['plainPassword'])) {
            return new JsonResponse(['error' => 'Invalid request'], 400);
        }

        $user = $entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $request['email']]);
        if ($user) {
            return new JsonResponse(['error' => 'User with this email already exists'], 400);
        }

        $user = new User();
        $user->setEmail($request['email']);
        $user->setPassword($userPasswordHasher->hashPassword($user, $request['plainPassword']));
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['success' => 'User created'], 200);
    }
}
