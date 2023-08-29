<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;

/**
 * Class UserFixtures.
 */
class UserFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->faker = Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            $user = new User();
            $user->setEmail($this->faker->safeEmail);
            $user->setPassword($this->faker->password);
            $this->manager->persist($user);
        }
        $this->manager->flush();
    }
}
