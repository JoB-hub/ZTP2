<?php

namespace App\DataFixtures;

use App\Entity\Game;
use DateTimeImmutable;
use Faker\Factory;

/**
* Class GameFixtures.
*/
class GameFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $game = new Game();
            $game->setTitle($this->faker->words(2, true));
            $game->setDescription($this->faker->sentence);
            $game->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $game->setPictureId($this->faker->randomDigit());
            $game->setGenreId($this->faker->randomDigit());
            $game->setStudioId($this->faker->randomDigit());
            $this->manager->persist($game);
        }
        $this->manager->flush();
    }
}
