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
        $zero = 0;

        while ($zero <= 100000) {
            $weightGen = $faker->numberBetween(55, 5555);
            $product = new Product();
            $product->setName($faker->sentence());
            $product->setWeight($weightGen);
            $manager->persist($product);

            $zero += $weightGen;
        }


        $manager->flush();
    }
}
