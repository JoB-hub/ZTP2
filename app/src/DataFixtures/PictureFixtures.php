<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class PictureFixtures.
 */
class PictureFixtures extends Fixture
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
            $picture = new Picture();
            $picture->setFilename($this->faker->imageUrl(640, 480, 'cars', true));
            $manager->persist($picture);
        }
        $manager->flush();
    }
}
