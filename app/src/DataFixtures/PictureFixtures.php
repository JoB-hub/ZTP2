<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Faker\Factory;

/**
 * Class PictureFixtures.
 */
class PictureFixtures extends AbstractBaseFixtures
{
    /**
     * Load.
     */
    public function loadData(): void
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 3; ++$i) {
            $picture = new Picture();
            $picture->setFilename($this->faker->unique()->word);
            $this->manager->persist($picture);
        }
        $this->manager->flush();
    }
}
