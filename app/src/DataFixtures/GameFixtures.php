<?php

namespace App\DataFixtures;

use App\Entity\Game;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class GameFixtures.
 */
class GameFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(10, 'game', function ($i) {
            $game = new Game();
            $game->setTitle($this->faker->word);
            $game->setDescription($this->faker->sentence);
            $game->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $game->setGenre($this->getRandomReference('genres'));
            return $game;
        });
        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: GenreFixtures::class}
     */
    public function getDependencies(): array
    {
        return [GenreFixtures::class];
    }
}
