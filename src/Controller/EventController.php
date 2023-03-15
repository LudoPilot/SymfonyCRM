<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/event')]
class EventController extends AbstractController
{
	// Displays all events in a view
	#[Route('/', name: 'app_event_index', methods: ['GET'])]
	public function index(EventRepository $eventRepository): Response
	{
		return $this->render('event/index.html.twig', [
			'events' => $eventRepository->findAll(),
		]);
	}

	#[Route('/api/events', methods: ['GET'])]
	public function apiAllEvents(EventRepository $eventRepository, Request $request): JsonResponse
	{
		/*
		$data = $eventRepository->findAll(); // modifier pour ne pas prendre tous les événements de la BDD
		return $this->json($data); */

		$user = $this->getUser(); // get the current authenticated user

		$start = new \DateTimeImmutable($request->query->get('start'));
		$end = new \DateTimeImmutable($request->query->get('end'));

		$events = $eventRepository->findAllEventsByUser($user);
		$response = [];

		foreach ($events as $event) {
			$response[] = [
				'id' => $event->getId(),
				'title' => $event->getTitle(),
				'start' => $event->getStartDate()->format('Y-m-d\TH:i:s'),
				'end' => $event->getEndDate()->format('Y-m-d\TH:i:s'),
			];
		}

		//return new JsonResponse($response);
		return $this->json($response);
	}

	#[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
	public function new(Request $request, EventRepository $eventRepository, Security $security): Response
	{
		$event = new Event();
		$event->setOrganizer($security->getUser()); // Set the current user as the organizer
		$form = $this->createForm(EventType::class, $event);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$eventRepository->save($event, true);

			return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->render('event/new.html.twig', [
			'event' => $event,
			'form' => $form->createView(),
		]);
	}

	#[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
	public function show(Event $event): Response
	{
		return $this->render('event/show.html.twig', [
			'event' => $event,
		]);
	}

	// First edit method (delete from the event page)
	#[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, Event $event, EntityManagerInterface $entityManager, EventRepository $eventRepository): Response
	{


		$form = $this->createForm(EventType::class, $event);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$eventRepository->save($event, true);

			return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->render('event/edit.html.twig', [
			'event' => $event,
			'form' => $form->createView(),
		]);
	}

	// Edit from the calendar
	#[Route('/api/events/{id}', name: 'api_event_edit', methods: ['PUT'])]
	public function apiEditEvent(Request $request, Event $event, EventRepository $eventRepository, EntityManagerInterface $entityManager): JsonResponse
	{
		$data = json_decode($request->getContent(), true);

		$event->setTitle($data['editEventTitle']);

		// Description is optional
		if (isset($data['description'])) {
			$event->setDescription($data['description']);
		}
		$event->setStartDate(new \DateTime($data['editEventStart']));
		$event->setEndDate(new \DateTime($data['editEventEnd']));

		$eventRepository->save($event);

		$entityManager->flush();

		$response = [
			'status' => 'ok',
		];

		return new JsonResponse($response);
	}

	// Delete from the list of events
	#[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
	public function delete(Request $request, Event $event, EventRepository $eventRepository): Response
	{
		if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
			$eventRepository->remove($event, true);
		}

		return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
	}

	// Delete from calendar
	#[Route('/calendar/{id}', name: 'app_event_delete_front', methods: ['DELETE'])]
	public function deleteFromCalendar(Request $request, Event $event, EventRepository $eventRepository, EntityManagerInterface $entityManager): JsonResponse
	{
		//var_dump($event->getId()); // Check if the ID is correct
		//var_dump($event); // Check if the entity is correctly retrieved

		$eventRepository->remove($event, true);
		$entityManager->flush();

		return new JsonResponse(['success' => true, 'message' => 'Event deleted successfully']);

		// The token seems invalid but we'll check that later
		// if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
		// 	$eventRepository->remove($event, true);
		// 	$entityManager->flush();

		// 	return new JsonResponse(['success' => true, 'message' => 'Event deleted successfully']);
		// }

		// return new JsonResponse(['success' => false, 'message' => 'Failed to delete event']);
	}
}
