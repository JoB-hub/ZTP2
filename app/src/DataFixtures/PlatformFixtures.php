<?php
//
//namespace App\DataFixtures;
//
//use App\Entity\Platform;
//use Faker\Factory;
//
///**
// * Class PlatformFixtures.
// */
//class PlatformFixtures extends AbstractBaseFixtures
//{
//    /**
//     * Load.
//     */
//    public function loadData(): void
//    {
//        $this->faker = Factory::create();
//        for ($i = 0; $i < 10; ++$i) {
//            $platform = new Platform();
//            $platform->setName($this->faker->word);
//            $this->manager->persist($platform);
//        }
//        $this->manager->flush();
//    }
//}



namespace App\DataFixtures;

use App\Entity\Platform;

/**
 * Class PlatformFixtures.
 */
class PlatformFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->createMany(5, 'platforms', function ($i) {
            $platform = new Platform();
            $platform->setName($this->faker->word);

            return $platform;
        }
        );
        $this->manager->flush();
    }
}
