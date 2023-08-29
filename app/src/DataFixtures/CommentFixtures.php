<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class CommentFixtures.
 */
class CommentFixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var Generator
     */
    protected Generator $faker;

    /**
     * Persistence object manager.
     *
     * @var ObjectManager
     */
    protected ObjectManager $manager;

    /**
     * Load.
     *
     * @param ObjectManager $manager Persistence object manager.
     */
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $comment = new Comment();
            $comment->setGamesId($this->faker->randomDigit());
            $comment->setUsersId($this->faker->randomDigit());
            $comment->setDescription($this->faker->sentence);
            $manager->persist($comment);
        }
        $manager->flush();
    }
}
