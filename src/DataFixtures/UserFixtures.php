<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['admin@test.fr', 'Admin', 'Root', ['ROLE_ADMIN']],
            ['user@test.fr', 'User', 'Basic', ['ROLE_USER']],
            ['manager@test.fr', 'Manager', 'Boss', ['ROLE_MANAGER']],
        ];

        foreach ($users as [$email, $firstname, $lastname, $roles]) {
            $user = new User();
            $user->setEmail($email);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setRoles($roles);
            $user->setPassword(
                $this->hasher->hashPassword($user, 'password')
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
