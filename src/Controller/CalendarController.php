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
	/* Only one route in CalendarController. This controller must only display the events. */
	public function index(Request $request): Response
	{
		// The access is authorized only if the user is authenticated
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED');
		
		$event = new Event();
		$form = $this->createForm(EventType::class, $event);
		$form->handleRequest($request);

		return $this->render('calendar/calendar.html.twig', [
			'controller_name' => 'CalendarController',
			'form' => $form->createView(),  // Check the purpose of the form(s)
		]);
	}
}
