<?php

namespace App\DataFixtures;

use App\Entity\Platform;
use Faker\Factory;

/**
 * Class PlatformFixtures.
 */
class PlatformFixtures extends AbstractBaseFixtures
{
    /**
     * Load.
     */
    public function loadData(): void
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $platform = new Platform();
            $platform->setName($this->faker->word);
            $this->manager->persist($platform);
        }
        $this->manager->flush();
    }
}
