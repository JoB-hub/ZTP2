<?php
/**
 * User fixtures.
 */

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;

/**
 * Class UserFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class UserFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(20, 'users', function (int $i) {
            $user = new User();
            $user->setNickname($this->faker->unique()->userName);
            $user->setEmail($this->faker->safeEmail);
            $user->setPassword($this->faker->password);

            return $user;
        });

        $this->manager->flush();
    }
}
