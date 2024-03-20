<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ServiceRepository;
use App\Repository\ScheduleRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ServiceRepository $serviceRepository, ScheduleRepository $scheduleRepository): Response
    {
        $services = $serviceRepository->findAll();
        $schedules = $scheduleRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'services' => $services,
            'schedules' => $schedules,
        ]);
    }
    
}
