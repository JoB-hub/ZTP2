<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Faker\Factory;

/**
 * Class GenreFixtures.
 */
class GenreFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $genre = new Genre();
            $genre->setName($this->faker->word);
            $genre->setDescription($this->faker->sentence);
            $this->manager->persist($genre);
        }
        $this->manager->flush();
    }
}
