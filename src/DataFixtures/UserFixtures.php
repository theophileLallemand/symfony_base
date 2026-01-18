<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['admin@test.fr', 'Admin', 'Demo', ['ROLE_ADMIN'], 'admin123'],
            ['manager@test.fr', 'Manager', 'Demo', ['ROLE_MANAGER'], 'manager123'],
            ['user@test.fr', 'User', 'Demo', ['ROLE_USER'], 'user123'],
        ];

        foreach ($users as [$email, $firstname, $lastname, $roles, $plainPassword]) {
            $user = new User();
            $user->setEmail($email);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setRoles($roles);
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
