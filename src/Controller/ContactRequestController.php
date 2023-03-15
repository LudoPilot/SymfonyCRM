<?php

namespace App\Controller;

use App\Entity\ContactRequest;
use App\Form\ContactRequestType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactRequestController extends AbstractController
{
    #[Route('/contact/request', name: 'app_contact_request')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
		$contactRequest = new ContactRequest();

		$form = $this->createForm(ContactRequestType::class, $contactRequest);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// Set an expiration date 
			$expirationDate = (new \DateTimeImmutable())->modify('+1 year');
			$contactRequest->setExpirationDate($expirationDate);

            // $form->getData() holds the submitted values
            // but, the original `$contactRequest` variable has also been updated
            $contactRequest = $form->getData();

			// create an email
			$address = $contactRequest->getEmail();
			$message = $contactRequest->getMessage();

			$email = (new Email())
            ->from($address)
            ->to('contact@symfonycrm.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Demande de contact')
            ->text($message);
            //->html('<p>See Twig integration for better HTML integration!</p>');

       		$mailer->send($email);
            $this->addFlash('success', 'Votre message nous a bien été envoyé.');
			// ... perform some action, such as saving the task to the database
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($contactRequest);
            // $entityManager->flush();

            return $this->redirectToRoute('app_contact_request');
        }


        return $this->render('contact_request/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
