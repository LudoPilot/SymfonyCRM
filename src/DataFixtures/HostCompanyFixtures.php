<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\HostCompanyFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class HostCompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		HostCompanyFactory::createOne();
    }
}