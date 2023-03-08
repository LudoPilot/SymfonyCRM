<?php

namespace App\Controller;

use App\Entity\ExternalCompany;
use App\Form\ExternalCompanyType;
use App\Repository\ExternalCompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/external/company')]
class ExternalCompanyController extends AbstractController
{
    #[Route('/', name: 'app_external_company_index', methods: ['GET'])]
    public function index(ExternalCompanyRepository $externalCompanyRepository): Response
    {
        return $this->render('external_company/index.html.twig', [
            'external_companies' => $externalCompanyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_external_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ExternalCompanyRepository $externalCompanyRepository): Response
    {
        $externalCompany = new ExternalCompany();
        $form = $this->createForm(ExternalCompanyType::class, $externalCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $externalCompanyRepository->save($externalCompany, true);

            return $this->redirectToRoute('app_external_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('external_company/new.html.twig', [
            'external_company' => $externalCompany,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_external_company_show', methods: ['GET'])]
    public function show(ExternalCompany $externalCompany): Response
    {
        return $this->render('external_company/show.html.twig', [
            'external_company' => $externalCompany,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_external_company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExternalCompany $externalCompany, ExternalCompanyRepository $externalCompanyRepository): Response
    {
        $form = $this->createForm(ExternalCompanyType::class, $externalCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $externalCompanyRepository->save($externalCompany, true);

            return $this->redirectToRoute('app_external_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('external_company/edit.html.twig', [
            'external_company' => $externalCompany,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_external_company_delete', methods: ['POST'])]
    public function delete(Request $request, ExternalCompany $externalCompany, ExternalCompanyRepository $externalCompanyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$externalCompany->getId(), $request->request->get('_token'))) {
            $externalCompanyRepository->remove($externalCompany, true);
        }

        return $this->redirectToRoute('app_external_company_index', [], Response::HTTP_SEE_OTHER);
    }
}
