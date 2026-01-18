<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['Clavier mécanique', 'Clavier RGB pour développeur', 89.99, 'physical'],
            ['Souris gaming', 'Souris précise et ergonomique', 49.90, 'physical'],
            ['Licence logiciel', 'Licence annuelle produit numérique', 129.00, 'digital'],
        ];

        foreach ($products as [$name, $desc, $price, $type]) {
            $p = new Product();
            $p->setName($name);
            $p->setDescription($desc);
            $p->setPrice((float) $price);
            $p->setType($type);

            $manager->persist($p);
        }

        $manager->flush();
    }
}
