<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class UserFixtures.
 */
class UserFixtures extends Fixture
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
            $user = new User();
            $user->setEmail($this->faker->safeEmail);
            $user->setPassword($this->faker->password(6,20));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
