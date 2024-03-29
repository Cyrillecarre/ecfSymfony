<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReparationController extends AbstractController
{
    #[Route('/reparation', name: 'app_reparation')]
    public function index(ScheduleRepository $scheduleRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_logout');
            
        }
        $schedules = $scheduleRepository->findAll();
        return $this->render('reparation/index.html.twig', [
            'controller_name' => 'ReparationController',
            'schedules' => $schedules
        ]);
    }
}
