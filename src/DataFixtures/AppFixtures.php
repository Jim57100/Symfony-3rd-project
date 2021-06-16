<?php

namespace App\DataFixtures;

use App\Entity\Aliments;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $a1 = new Aliments();
        $a1 -> setNom("Carotte")
            -> setPrix("1.8")
            -> setCalories("36")
            -> setImage("aliments/carotte.png")
            -> setProteine(0.77)
            -> setGlucide(6.45)
            -> setLipides(0.26);
        $a1 -> setUpdatedAt(new \DateTime('now'));
        $manager->persist($a1);

        $a2 = new Aliments();
        $a2 -> setNom("Patate")
            -> setPrix("1.5")
            -> setCalories("80")
            -> setImage("aliments/patate.png")
            -> setProteine(0.86)
            -> setGlucide(16.7)
            -> setLipides(0.34);
        $manager->persist($a2);

        $a3 = new Aliments();
        $a3 -> setNom("Tomate")
            -> setPrix("2.3")
            -> setCalories("18")
            -> setImage("aliments/tomate.png")
            -> setProteine(0.86)
            -> setGlucide(2.26)
            -> setLipides(0.24);
        $manager->persist($a3);

        $a4 = new Aliments();
        $a4 -> setNom("Pomme")
            -> setPrix("2.35")
            -> setCalories("52")
            -> setImage("aliments/pomme.png")
            -> setProteine(0.25)
            -> setGlucide(11.6)
            -> setLipides(0.25);
        $manager->persist($a4);

        $manager->flush();
    }
}
