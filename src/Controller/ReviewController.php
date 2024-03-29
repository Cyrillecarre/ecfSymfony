<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ScheduleRepository;

#[Route('/review')]
class ReviewController extends AbstractController
{
    #[Route('/', name: 'app_review_index', methods: ['GET'])]
    public function index(ReviewRepository $reviewRepository, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('review/index.html.twig', [
            'reviews' => $reviewRepository->findAll(),
            'schedules' => $schedules,
        ]);
    }

    #[Route('/new', name: 'app_review_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('app_review_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('review/new.html.twig', [
            'review' => $review,
            'form' => $form,
            'schedules' => $schedules,
        ]);
    }

    #[Route('/show', name: 'app_review_show', methods: ['GET'])]
    public function show(ReviewRepository $reviewRepository, ScheduleRepository $scheduleRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_logout');
            
        }
        $schedules = $scheduleRepository->findAll();
        return $this->render('review/show.html.twig', [
            'reviews' => $reviewRepository->findAll(),
            'schedules' => $schedules,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_review_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Review $review, EntityManagerInterface $entityManager, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setApprouved(true);
            $entityManager->flush();

            return $this->redirectToRoute('app_review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('review/edit.html.twig', [
            'review' => $review,
            'form' => $form,
            'schedules' => $schedules,
        ]);
    }

    #[Route('/{id}', name: 'app_review_delete', methods: ['POST'])]
    public function delete(Request $request, Review $review, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_review_index', [], Response::HTTP_SEE_OTHER);
    }

    public function home(ReviewRepository $reviewRepository, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('home/index.html.twig', [
            'reviews' => $reviewRepository->findAll(),
            'schedules' => $schedules,
        ]);
    }
}
