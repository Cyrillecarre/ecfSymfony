<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RenderController extends AbstractController
{
    #[Route('/render', name: 'app_render')]
    public function index(ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('render/schedule.html.twig', [
            'controller_name' => 'RenderController',
            'schedules' => $schedules,
        ]);
    }
}
