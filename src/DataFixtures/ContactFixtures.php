<?php

namespace App\DataFixtures;

use App\Factory\ContactFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		ContactFactory::createMany(10);
    }
}