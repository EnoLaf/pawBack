<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VaccinationController extends AbstractController
{
    #[Route('/vaccination', name: 'app_vaccination')]
    public function index(): Response
    {
        return $this->render('vaccination/index.html.twig', [
            'controller_name' => 'VaccinationController',
        ]);
    }

    #[Route('/vaccination/create', name: 'app_vaccination_create')]
    public function createVaccination(): Response
    {
        return $this->render('vaccination/index.html.twig', [
            'controller_name' => 'VaccinationController',
        ]);
    }

    #[Route('/vaccination/readVaccination', name: 'app_vaccination_read')]
    public function readVaccination(): Response
    {
        return $this->render('vaccination/index.html.twig', [
            'controller_name' => 'VaccinationController',
        ]);
    }
}
