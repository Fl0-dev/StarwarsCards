<?php

namespace App\Controller;

use App\Service\StarWarsApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // Pour récupérer le Service StarWarsApi
    public function __construct(
        private StarWarsApi $starWarsApi,
    ) {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'personnages' => $this->starWarsApi->getPersonnages(),
        ]);
    }

    #[Route('/personnage/{id}', name: 'app_personnage', requirements: ['id' => '\d+'])]
    public function personnage(int $id): Response
    {
        return $this->render('home/personnage.html.twig', [
            'personnage' => $this->starWarsApi->getPersonnage($id),
        ]);
    }
}
