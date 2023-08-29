<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class GenreFixtures.
 */
class GenreFixtures extends Fixture
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
            $genre = new Genre();
            $genre->setName($this->faker->word);
            $genre->setDescription($this->faker->sentence);
            $manager->persist($genre);
        }
        $manager->flush();
    }
}
