<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();



        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $product->setName($faker->sentence());
            $product->setWeight($faker->numberBetween(55, 5555));
            $manager->persist($product);
        }


        $manager->flush();
    }
}
