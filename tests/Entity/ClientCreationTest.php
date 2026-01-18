<?php

namespace App\Tests\Entity;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ClientCreationTest extends TestCase
{
    public function testClientIsPersisted(): void
    {
        $client = new Client();
        $client->setFirstname('Jean')
            ->setLastname('Dupont')
            ->setEmail('jean.dupont@test.fr')
            ->setPhoneNumber('0601020304')
            ->setAddress('1 rue de Paris')
            ->setCreatedAt(new \DateTimeImmutable());

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($client);

        $entityManager->expects($this->once())
            ->method('flush');

        // Simulation d’un service ou controller
        $entityManager->persist($client);
        $entityManager->flush();

        $this->assertEquals('Jean', $client->getFirstname());
        $this->assertEquals('Dupont', $client->getLastname());
    }
}
