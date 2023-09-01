<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use DateTimeImmutable;
use Faker\Factory;

/**
 * Class CommentFixtures.
 */
class CommentFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $comment = new Comment();
            $comment->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $comment->setUpdatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $comment->setDescription($this->faker->sentence);
            $this->manager->persist($comment);
        }
        $this->manager->flush();
    }
}
