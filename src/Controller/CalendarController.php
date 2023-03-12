<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('calendar/index.html.twig', [
            'controller_name' => 'CalendarController',
        ]);
    }


	public function delete(Event $event): Response
    {
        // Delete the event from the database
        // $entityManager = $this->getDoctrine()->getManager();
        // $entityManager->remove($event);
        // $entityManager->flush();

        // Redirect to the calendar events page
        return $this->redirectToRoute('calendar_events');
    }
}
