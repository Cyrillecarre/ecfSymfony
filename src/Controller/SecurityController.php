<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Cookie;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        

        if ($this->getUser()) {
            $roles = $this->getUser()->getRoles();
            $routeName = match ($roles[0]) {
                'ROLE_ADMIN' => 'app_admin',
                'ROLE_USER' => 'app_user',
                default => 'app_home',
            };
            return $this->redirectToRoute($routeName);
    }

        $response = $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);

        $response->headers->setCookie(
            Cookie::create('sf_redirect', 'valeur_du_cookie', 0, '/', null, false, true)
                ->withSameSite(Cookie::SAMESITE_NONE)
        );

        return $response;
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
