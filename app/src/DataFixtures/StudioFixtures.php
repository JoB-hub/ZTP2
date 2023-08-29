<?php

namespace App\DataFixtures;

use App\Entity\Studio;
use Faker\Factory;

/**
 * Class StudioFixtures.
 */
class StudioFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $studio = new Studio();
            $studio->setName($this->faker->words(2, true));
            $this->manager->persist($studio);
        }
        $this->manager->flush();
    }
}
