<?php
/**
 * Game fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Platform;
use App\Entity\User;
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
        if (null === $this->manager || null === $this->faker) {
            return;
        }
        $this->createMany(10, 'games', function ($i) {
            $game = new Game();
            $game->setTitle($this->faker->word);
            $game->setDescription($this->faker->sentence);
            $game->setCreatedAt(
                \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $game->setGenre($this->getRandomReference('genres'));
            $game->setStudio($this->getRandomReference('studios'));
            //            $game->addPicture($this->getRandomReference('pictures'));

            /** @var array<array-key, Platform> $platforms */
            $platforms = $this->getRandomReferences(
                'platforms',
                $this->faker->numberBetween(0, 5)
            );
            foreach ($platforms as $platform) {
                $game->addPlatform($platform);
            }
            /** @var User $author */
            $author = $this->getRandomReference('users');
            $game->setAuthor($author);

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
        return [GenreFixtures::class, StudioFixtures::class];
    }
}
