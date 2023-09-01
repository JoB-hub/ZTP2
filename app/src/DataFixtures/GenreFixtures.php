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
        $this->createMany(5, 'genres', function ($i) {
            $genre = new Genre();
            $genre->setName($this->faker->word);
            $genre->setDescription($this->faker->sentence);
            return $genre;
        });
        $this->manager->flush();
    }
}
