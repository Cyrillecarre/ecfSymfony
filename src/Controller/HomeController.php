<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ServiceRepository $serviceRepository, ReviewRepository $reviewRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_logout');    
        }
        
        $services = $serviceRepository->findAll();
        $reviews = $reviewRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'services' => $services,
            'reviews' => $reviews,
        ]);
    }
    
}
