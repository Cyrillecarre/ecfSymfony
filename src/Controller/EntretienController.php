<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EntretienController extends AbstractController
{
    #[Route('/entretien', name: 'app_entretien')]
    public function index(ScheduleRepository $scheduleRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_logout');
            
        }
        $schedules = $scheduleRepository->findAll();
        return $this->render('entretien/index.html.twig', [
            'controller_name' => 'EntretienController',
            'schedules' => $schedules,
        ]);
    }
}
