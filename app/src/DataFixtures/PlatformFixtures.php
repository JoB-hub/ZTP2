<?php
/**
 * Platform fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Platform;

/**
 * Class PlatformFixtures.
 */
class PlatformFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->createMany(5, 'platforms', function ($i) {
            $platform = new Platform();
            $platform->setName($this->faker->word);

            return $platform;
        });
        $this->manager->flush();
    }
}
