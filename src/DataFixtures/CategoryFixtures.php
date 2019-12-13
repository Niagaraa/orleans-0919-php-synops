<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i<5; $i++) {
            $category = new Category();
            $category->setSector($faker->realText(50));
            $this->addReference('category_' . $i, $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
