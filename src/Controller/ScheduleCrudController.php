<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Form\ScheduleType;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/schedule/crud')]
class ScheduleCrudController extends AbstractController
{
    #[Route('/', name: 'app_schedule_crud_index', methods: ['GET'])]
    public function index(ScheduleRepository $scheduleRepository): Response
    {
        return $this->render('schedule_crud/index.html.twig', [
            'schedules' => $scheduleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_schedule_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $schedule = new Schedule();
        $form = $this->createForm(ScheduleType::class, $schedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $entityManager->persist($schedule);
            $entityManager->flush();

            return $this->redirectToRoute('app_schedule_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('schedule_crud/new.html.twig', [
            'schedule' => $schedule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_schedule_crud_show', methods: ['GET'])]
    public function show(Schedule $schedule): Response
    {
        return $this->render('schedule_crud/show.html.twig', [
            'schedule' => $schedule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_schedule_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Schedule $schedule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScheduleType::class, $schedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($schedule);
            $entityManager->flush();

            $this->addFlash('success', 'Schedule updated successfully!');

            return $this->redirectToRoute('app_schedule_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('schedule_crud/edit.html.twig', [
            'schedule' => $schedule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_schedule_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Schedule $schedule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$schedule->getId(), $request->request->get('_token'))) {
            $entityManager->remove($schedule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_schedule_crud_index', [], Response::HTTP_SEE_OTHER);
    }

}
