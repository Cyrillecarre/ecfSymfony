<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReparationController extends AbstractController
{
    #[Route('/reparation', name: 'app_reparation')]
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_logout');    
        }
        
        return $this->render('reparation/index.html.twig', [
            'controller_name' => 'ReparationController',
        ]);
    }
}
