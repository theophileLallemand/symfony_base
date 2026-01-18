<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard', methods: ['GET'])]
    public function index(
        ProductRepository $productRepository,
        ClientRepository $clientRepository,
        EntityManagerInterface $em
    ): Response {
        $productCount = $productRepository->count([]);
        $clientCount = $clientRepository->count([]);

        $userCount = (int) $em->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(User::class, 'u')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('dashboard/index.html.twig', [
            'productCount' => $productCount,
            'clientCount' => $clientCount,
            'userCount' => $userCount,
        ]);
    }
}
