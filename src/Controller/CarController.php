<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ScheduleRepository;
use symfony\component\httpfoundation\file\uploadedfile;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/car')]
class CarController extends AbstractController
{
    #[Route('/', name: 'app_car_index', methods: ['GET'])]
    public function index(CarRepository $carRepository, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('car/index.html.twig', [
            'cars' => $carRepository->findAll(),
            'schedules' => $schedules,
        ]);
    }

    #[Route('/new', name: 'app_car_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imagePath')->getData();
            $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('kernel.project_dir') . '/public/uploads/',
                $imageName
            );
            $car->setImagePath($imageName);

            $imageFile2 = $form->get('photo2')->getData();
            if ($imageFile2) {
                $imageName2 = md5(uniqid()) . '.' . $imageFile2->guessExtension();
                $imageFile2->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/',
                    $imageName2
                );
                $car->setPhoto2($imageName2);
            }

            $imageFile3 = $form->get('photo3')->getData();
            if ($imageFile3) {
                $imageName3 = md5(uniqid()) . '.' . $imageFile3->guessExtension();
                $imageFile3->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/',
                    $imageName3
                );
                $car->setPhoto3($imageName3);
            }

            $imageFile4 = $form->get('photo4')->getData();
            if ($imageFile4) {
                $imageName4 = md5(uniqid()) . '.' . $imageFile4->guessExtension();
                $imageFile4->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/',
                    $imageName4
                );
                $car->setPhoto4($imageName4);
            }

            $imageFile5 = $form->get('photo5')->getData();
            if ($imageFile5) {
                $imageName5 = md5(uniqid()) . '.' . $imageFile5->guessExtension();
                $imageFile5->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/',
                    $imageName5
                );
                $car->setPhoto5($imageName5);
            }

            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_car_index');
        }

    return $this->render('car/new.html.twig', [
        'car' => $car,
        'form' => $form->createView(),
        'schedules' => $schedules,
    ]);
}

    

    #[Route('/show', name: 'app_car_show', methods: ['GET', 'POST'])]
    public function show(CarRepository $carRepository, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('car/show.html.twig', [
            'cars' => $carRepository->findAll(),
            'schedules' => $schedules,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, EntityManagerInterface $entityManager, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
            'schedules' => $schedules,
        ]);
    }

    #[Route('/{id}', name: 'app_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/showDetail/{id}/', name: 'app_car_showDetail', methods: ['GET'])]
    public function showDetail(int $id, CarRepository $carRepository, ScheduleRepository $scheduleRepository, UrlGeneratorInterface $urlGenerator, Car $car): Response
    {
        
        $schedules = $scheduleRepository->findAll();
        $car = $carRepository->find($id);

        if (!$car) {
            throw $this->createNotFoundException('Voiture non trouvée');
        }

        $mainPhoto = $car->getImagePath();
        $otherPhotos = [
            $car->getPhoto2(),
            $car->getPhoto3(),
            $car->getPhoto4(),
            $car->getPhoto5(),
        ];

        $contactFormUrl = $urlGenerator->generate('contact_form', [
            'car_name' => $car->getName(),
            'car_price' => $car->getPrice(),
        ]);

        return $this->render('car/showDetail.html.twig', [
            'car' => $car,
            'mainPhoto' => $mainPhoto,
            'otherPhotos' => $otherPhotos,
            'schedules' => $schedules,
            'contactFormUrl' => $contactFormUrl,
        ]);
    }
}