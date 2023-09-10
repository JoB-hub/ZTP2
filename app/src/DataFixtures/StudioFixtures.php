<?php
/**
 * Studio fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Studio;
use DateTimeImmutable;

/**
 * Class StudioFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class StudioFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(20, 'studios', function (int $i) {
            $studio = new Studio();
            $studio->setName($this->faker->unique()->word);

            return $studio;
        });

        $this->manager->flush();
    }
}
