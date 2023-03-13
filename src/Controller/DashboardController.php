<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
	/* When I keep the app_dashboard route with the /dashboard path, it works. 
	I added LoggerInterface.
	*/

    //#[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request, LoggerInterface $logger): Response
    {
		// The access is authorized only if the user is authenticated
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED');

		// // Get user ID from session
		// $session = $request->getSession();
		// $userId = $session->get('user.id');
		
		// // Fetch user data from database using user ID
		// $userRepository = $this->getDoctrine()->getRepository(User::class);
		// $user = $userRepository->find($userId);



        return $this->render('dashboard/index.html.twig', [
			//'user' => $user,
            'controller_name' => 'DashboardController',
        ]);
    }
}
