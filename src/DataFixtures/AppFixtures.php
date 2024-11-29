<?php

namespace App\DataFixtures;

use App\Entity\Bidule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for($i= 0; $i < 50; $i++){

            $bidule = new Bidule();
            $bidule
                ->setName("Bidule $i")
                ->setWidth(rand(0, 50))
                ->setDate(new \DateTime());

            $manager->persist($bidule);
        }

        $manager->flush();
    }
}
