<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\ContactType;
use App\Repository\CarRepository;
use App\Repository\ScheduleRepository;
use App\Form\ContactDetailType;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    #[Route('/contact/form', name: 'contact_form')]
    public function contactForm(Request $request, MailerInterface $mailer, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        $form = $this->createForm(ContactDetailType::class);

        $form->get('subject')->setData($request->get('car_name'));
        $form->get('message')->setData("Prix : " .$request->get('car_price') . " €");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $carName = $formData['car_name'];
            $carPrice = $formData['car_price'];

            $email = (new Email())
                ->from($formData['email'])
                ->to('votre_email@example.com')
                ->subject($carName)
                ->text("Message:" . $carPrice);
            
            $mailer->send($email);

            return $this->redirectToRoute('contact_confirmation');
        }

        return $this->render('contact/personal.html.twig', [
            'form' => $form->createView(),
            'schedules' => $schedules,
        ]);
    }
    

    #[Route('/contact/general', name: 'contact_general')]
    public function contactGeneral (MailerInterface $mailer, Request $request, ScheduleRepository $scheduleRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_logout');
            
        }
        $schedules = $scheduleRepository->findAll();
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $email = (new Email())
                ->from($formData['email'])
                ->to('mon_email@gmail.com')
                ->subject($formData['subject'])
                ->text("Message: " . $formData['message']);

            $mailer->send($email);

            return $this->redirectToRoute('contact_confirmation');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'schedules' => $schedules,
        ]);
    }



    #[Route('/contact/confirmation', name: 'contact_confirmation')]
    public function contactConfirmation(ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll();
        return $this->render('contact/confirmation.html.twig', [
            'schedules' => $schedules,
        ]);
    }
}

