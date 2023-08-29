<?php

namespace App\DataFixtures;

use App\Entity\Game;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
* Class GameFixtures.
*/
class GameFixtures extends Fixture
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
            $game = new Game();
            $game->setTitle($this->faker->words(2, true));
            $game->setDescription($this->faker->sentence);
            $game->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $game->setGenreId($this->faker->randomDigit());
            $game->setStudioId($this->faker->randomDigit());
            $manager->persist($game);
        }
        $manager->flush();
    }
}
