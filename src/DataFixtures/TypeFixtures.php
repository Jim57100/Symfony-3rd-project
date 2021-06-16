<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $t1 = new Type();
        $t1->setLibelle('Fruits')
            ->setImage('fruits.jpg');
        $manager->persist($t1);

        $t2 = new Type();
        $t2->setLibelle('Legumes')
            ->setImage('legumes.jpg');
        $manager->persist($t2);

        $manager->flush();
    }
}
