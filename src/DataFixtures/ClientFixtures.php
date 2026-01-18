<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['Jean', 'Dupont', 'jean.dupont@demo.fr', '0612345678', '12 rue de Metz, 57000 Metz'],
            ['Marie', 'Martin', 'marie.martin@demo.fr', '0698765432', '8 avenue Foch, 57000 Metz'],
            ['Lucas', 'Bernard', 'lucas.bernard@demo.fr', '0601020304', '5 rue des Jardins, 57000 Metz'],
            ['Emma', 'Petit', 'emma.petit@demo.fr', '0605060708', '21 rue Nationale, 57000 Metz'],
            ['Hugo', 'Robert', 'hugo.robert@demo.fr', '0677889900', '3 impasse des Lilas, 57000 Metz'],
            ['Lina', 'Richard', 'lina.richard@demo.fr', '0622334455', '44 boulevard Paixhans, 57000 Metz'],
            ['Noah', 'Durand', 'noah.durand@demo.fr', '0655443322', '9 rue Serpenoise, 57000 Metz'],
            ['Chloé', 'Moreau', 'chloe.moreau@demo.fr', '0611112222', '14 rue des Allemands, 57000 Metz'],
            ['Tom', 'Fournier', 'tom.fournier@demo.fr', '0633334444', '2 rue Haute Seille, 57000 Metz'],
            ['Sarah', 'Lambert', 'sarah.lambert@demo.fr', '0666667777', '18 rue de la Tête d’Or, 57000 Metz'],
        ];

        foreach ($data as [$firstname, $lastname, $email, $phone, $address]) {
            $client = new Client();
            $client->setFirstname($firstname);
            $client->setLastname($lastname);
            $client->setEmail($email);
            $client->setPhoneNumber($phone);
            $client->setAddress($address);
            $client->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($client);
        }

        $manager->flush();
    }
}
