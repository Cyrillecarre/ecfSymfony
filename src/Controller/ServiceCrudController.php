<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ScheduleRepository;

#[Route('/service/crud')]
class ServiceCrudController extends AbstractController
{
    #[Route('/', name: 'app_service_crud_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('service_crud/index.html.twig', [
            'services' => $serviceRepository->findAll(),
            'schedules' => $schedules,
        ]);
    }

    #[Route('/new', name: 'app_service_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_service_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service_crud/new.html.twig', [
            'service' => $service,
            'form' => $form,
            'schedules' => $schedules,
        ]);
    }

    #[Route('/{id}', name: 'app_service_crud_show', methods: ['GET'])]
    public function show(Service $service, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('service_crud/show.html.twig', [
            'service' => $service,
            'schedules' => $schedules,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, EntityManagerInterface $entityManager, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_service_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service_crud/edit.html.twig', [
            'service' => $service,
            'form' => $form,
            'schedules' => $schedules,
        ]);
    }

    #[Route('/{id}', name: 'app_service_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_service_crud_index', [], Response::HTTP_SEE_OTHER);
    }

    public function home(ServiceRepository $serviceRepository, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('home/index.html.twig', [
            'services' => $serviceRepository,
            'schedules' => $schedules,
        ]);
    }
}
