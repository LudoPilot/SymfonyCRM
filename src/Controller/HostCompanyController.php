<?php

namespace App\Controller;

use App\Entity\HostCompany;
use App\Form\HostCompanyType;
use App\Repository\HostCompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/host/company')]
class HostCompanyController extends AbstractController
{
    #[Route('/', name: 'app_host_company_index', methods: ['GET'])]
    public function index(HostCompanyRepository $hostCompanyRepository): Response
    {
        return $this->render('host_company/index.html.twig', [
            'host_companies' => $hostCompanyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_host_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HostCompanyRepository $hostCompanyRepository): Response
    {
        $hostCompany = new HostCompany();
        $form = $this->createForm(HostCompanyType::class, $hostCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hostCompanyRepository->save($hostCompany, true);

            return $this->redirectToRoute('app_host_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('host_company/new.html.twig', [
            'host_company' => $hostCompany,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_host_company_show', methods: ['GET'])]
    public function show(HostCompany $hostCompany): Response
    {
        return $this->render('host_company/show.html.twig', [
            'host_company' => $hostCompany,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_host_company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HostCompany $hostCompany, HostCompanyRepository $hostCompanyRepository): Response
    {
        $form = $this->createForm(HostCompanyType::class, $hostCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hostCompanyRepository->save($hostCompany, true);

            return $this->redirectToRoute('app_host_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('host_company/edit.html.twig', [
            'host_company' => $hostCompany,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_host_company_delete', methods: ['POST'])]
    public function delete(Request $request, HostCompany $hostCompany, HostCompanyRepository $hostCompanyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hostCompany->getId(), $request->request->get('_token'))) {
            $hostCompanyRepository->remove($hostCompany, true);
        }

        return $this->redirectToRoute('app_host_company_index', [], Response::HTTP_SEE_OTHER);
    }
}
