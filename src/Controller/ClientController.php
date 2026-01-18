<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/clients')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'client_index')]
    public function index(ClientRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('CLIENT_ACCESS');

        return $this->render('client/index.html.twig', [
            'clients' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'client_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        ClientRepository $repo
    ): Response {
        $this->denyAccessUnlessGranted('CLIENT_ACCESS');

        $client = new Client();
        $client->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($repo->emailExists($client->getEmail())) {
                $this->addFlash('error', 'Email déjà utilisé.');
            } else {
                $em->persist($client);
                $em->flush();
                return $this->redirectToRoute('client_index');
            }
        }

        return $this->render('client/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'client_edit')]
    public function edit(
        Client $client,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('CLIENT_ACCESS');

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
