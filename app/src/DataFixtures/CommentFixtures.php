<?php
/**
 * Comment fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class CommentFixtures.
 */
class CommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }
        $this->faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $comment = new Comment();
            $comment->setCreatedAt(
                \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $comment->setUpdatedAt(
                \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $comment->setDescription($this->faker->sentence);
            $comment->setGame($this->getRandomReference('games'));
            $comment->setAuthor($this->getRandomReference('users'));
            $this->manager->persist($comment);
        }
        $this->manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [GameFixtures::class, UserFixtures::class];
    }
}
