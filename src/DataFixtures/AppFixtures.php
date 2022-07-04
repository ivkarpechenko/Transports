<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $company = new Company();
            $company->setName("company ".$i);
            $company->setVolumeCost(mt_rand(1, 5));
            $company->setWeightCost(mt_rand(1, 5));
            $manager->persist($company);
        }

        $manager->flush();
    }
}
