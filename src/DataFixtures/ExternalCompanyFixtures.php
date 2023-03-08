<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\ExternalCompanyFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ExternalCompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		ExternalCompanyFactory::createMany(10);
    }
}