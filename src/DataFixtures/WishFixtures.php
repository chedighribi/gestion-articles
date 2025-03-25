<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WishFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 20; $i++)
        {
            $wish = new Wish();
            $wish->setTitle($faker->sentence(2));
            $wish->setDescription($faker->realText(50));
            $wish->setAuthor($faker->name());
            $wish->setDateCreated($faker->dateTime());
            $wish->setIsPublished(boolval(70));
            $manager->persist($wish);
        }
        $manager->flush();
    }
}
