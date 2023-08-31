<?php

namespace App\DataFixtures;

use App\Entity\Comment;
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
            $comment->setGameId($this->faker->randomDigit());
            $comment->setUserId($this->faker->randomDigit());
            $comment->setDescription($this->faker->sentence);
            $this->manager->persist($comment);
        }
        $this->manager->flush();
    }
}
