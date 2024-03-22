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
use App\Entity\CarPhoto;
use symfony\component\httpfoundation\file\uploadedfile;

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
            // Enregistrement des détails de la voiture dans la table Car
            $entityManager->persist($car);
            $entityManager->flush();
    
            // Récupération des autres photos du formulaire
            $otherPhotos = $request->files->get('car')['otherPhotos'];
    
            // Enregistrement des chemins d'accès des autres photos dans la table CarPhoto
            foreach ($otherPhotos as $photo) {
                // Génération d'un nom de fichier unique pour la photo
                $fileName = md5(uniqid()) . '.' . $photo->guessExtension();
                
                // Déplacement de la photo vers le répertoire de destination
                $photo->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/',
                    $fileName
                );
    
                // Création de l'entité CarPhoto et association avec la voiture enregistrée
                $carPhoto = new CarPhoto();
                $carPhoto->setCar($car);
                $carPhoto->setImagePath($fileName);
                
                // Enregistrement de l'entité CarPhoto dans la base de données
                $entityManager->persist($carPhoto);
            }
    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_car_index');
        }
    
        return $this->render('car/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
            'schedules' => $schedules,
        ]);
    }

    #[Route('/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('car/show.html.twig', [
            'car' => $car,
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
}
