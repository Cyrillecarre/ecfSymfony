<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Schedule;

class FootController extends AbstractController
{
    #[Route('/foot', name: 'app_foot')]
    public function index(ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();

        return $this->render('foot/index.html.twig', [
            'controller_name' => 'FootController',
            'schedules' => $schedules,
        ]);
    }
}
