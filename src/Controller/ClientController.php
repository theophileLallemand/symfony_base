<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/clients', name: 'client_index', methods: ['GET'])]
    public function index(): Response
    {
        // plus tard: récupérer les clients via repository
        return $this->render('client/index.html.twig');
    }
}
