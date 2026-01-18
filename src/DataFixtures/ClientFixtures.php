<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $client = new Client();
            $client->setFirstname('Client'.$i);
            $client->setLastname('Test');
            $client->setEmail("client$i@test.fr");
            $client->setPhoneNumber('060000000'.$i);
            $client->setAddress('Adresse client '.$i);
            $client->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($client);
        }

        $manager->flush();
    }
}
