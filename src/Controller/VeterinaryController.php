<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VeterinaryController extends AbstractController
{
    #[Route('/veterinary', name: 'app_veterinary')]
    public function index(): Response
    {
        return $this->render('v_veterinary/index.html.twig', [
            'controller_name' => 'VVeterinaryController',
        ]);
    }

    #[Route('/veterinary/create', name: 'app_veterinary_create')]
    public function createVeterinary(): Response
    {
        return $this->render('v_veterinary/index.html.twig', [
            'controller_name' => 'VVeterinaryController',
        ]);
    }

    #[Route('/veterinary/read', name: 'app_veterinary_read')]
    public function readVeterinary(): Response
    {
        return $this->render('v_veterinary/index.html.twig', [
            'controller_name' => 'VVeterinaryController',
        ]);
    }

    #[Route('/veterinary/update', name: 'app_veterinary_update')]
    public function updateVeterinary(): Response
    {
        return $this->render('v_veterinary/index.html.twig', [
            'controller_name' => 'VVeterinaryController',
        ]);
    }

    #[Route('/veterinary/desactivate', name: 'app_veterinary_desactivate')]
    public function desactivateVeterinary(): Response
    {
        return $this->render('v_veterinary/index.html.twig', [
            'controller_name' => 'VVeterinaryController',
        ]);
    }
}
