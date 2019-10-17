<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100 ; $i++){
        $property = new Property();
        $property
            ->setTitle($faker->words(3, true))
            ->setDescription($faker->sentences(3, true))
            ->setSurface($faker->numberBetween($min = 50, $max= 8000))
            ->setFloor($faker->numberBetween($min = 0, $max = 2))
            ->setPrice($faker->numberBetween($min = 20000 , $max = 10000000))
            ->setCity($faker->city)
            ->setAddress($faker->address)
            ->setPostalCode($faker->postcode)
            ->setLogement($faker->numberBetween($min = 0, $max = 1))
            ->setSold(false);
        $manager->persist($property);
        }
        $manager->flush();
    }
}
