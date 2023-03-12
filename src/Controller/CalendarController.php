<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{

    public function index(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        return $this->render('calendar/calendar.html.twig', [
            'controller_name' => 'CalendarController',
            'form' => $form->createView(),
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
