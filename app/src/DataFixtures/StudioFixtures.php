<?php

namespace App\DataFixtures;

use App\Entity\Studio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class StudioFixtures.
 */
class StudioFixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var Generator
     */
    protected Generator $faker;

    /**
     * Persistence object manager.
     *
     * @var ObjectManager
     */
    protected ObjectManager $manager;

    /**
     * Load.
     *
     * @param ObjectManager $manager Persistence object manager.
     */
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $studio = new Studio();
            $studio->setName($this->faker->words(2, true));
            $manager->persist($studio);
        }
        $manager->flush();
    }
}
