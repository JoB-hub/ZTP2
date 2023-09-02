<?php
/**
 * Picture fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Picture;

/**
 * Class PictureFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class PictureFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(20, 'pictures', function (int $i) {
            $picture = new Picture();
            $picture->setFilename($this->faker->unique()->word);
            return $picture;
        });

        $this->manager->flush();
    }
}
