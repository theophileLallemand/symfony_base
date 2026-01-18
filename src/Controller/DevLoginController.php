<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class DevLoginController extends AbstractController
{
    #[Route('/dev/login-admin', name: 'dev_login_admin', methods: ['GET'])]
    public function loginAdmin(
        UserRepository $userRepository,
        EntityManagerInterface $em
    ): RedirectResponse {
        if ($this->getParameter('kernel.environment') !== 'dev') {
            throw $this->createNotFoundException();
        }

        $admin = $userRepository->findOneBy(['email' => 'admin@test.fr']);

        if (!$admin) {
            $this->addFlash('error', 'Utilisateur admin@test.fr introuvable. Lance les fixtures.');
            return $this->redirectToRoute('app_dashboard');
        }

        // Force ROLE_ADMIN en dev (sans toucher au mot de passe)
        $roles = $admin->getRoles();
        if (!in_array('ROLE_ADMIN', $roles, true)) {
            $roles[] = 'ROLE_ADMIN';
            $admin->setRoles(array_values(array_unique($roles)));
            $em->flush();
        }

        $this->addFlash('success', 'Compte admin activé (ROLE_ADMIN) en dev.');
        return $this->redirectToRoute('app_dashboard');
    }
}
