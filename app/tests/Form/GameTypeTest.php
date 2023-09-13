<?php

namespace App\Tests\Form;
use App\Entity\Game;
use App\Form\Type\GameType;
use App\Form\DataTransformer\PlatformsDataTransformer;
use App\Form\DataTransformer\PicturesDataTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase; // Import KernelTestCase
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameTypeTest extends KernelTestCase // Extend KernelTestCase
{
    private FormFactoryInterface $formFactory;

    protected function setUp(): void
    {
        parent::setUp();

        // Boot the Symfony kernel
        self::bootKernel();

        // Retrieve the form factory from the container
        $this->formFactory = self::$container->get(FormFactoryInterface::class);
    }

    public function testBuildForm(): void
    {
        // Create a mock PlatformsDataTransformer and PicturesDataTransformer
        $platformsDataTransformer = $this->createMock(PlatformsDataTransformer::class);
        $picturesDataTransformer = $this->createMock(PicturesDataTransformer::class);

        $builder = $this->formFactory->createBuilder(); // Use the form factory to create a builder

        // Create an instance of GameType with mock dependencies
        $gameType = new GameType($platformsDataTransformer, $picturesDataTransformer);

        // Build the form
        $gameType->buildForm($builder, []);

        // Perform assertions for each form field
        $form = $builder->getForm();

        $this->assertTrue($form->has('title'));
        $this->assertTrue($form->has('description'));
        $this->assertTrue($form->has('genre'));
        $this->assertTrue($form->has('studio'));
        $this->assertTrue($form->has('platforms'));
        $this->assertTrue($form->has('file'));

        // You can perform more specific assertions for each field and its options as needed.
    }

    public function testConfigureOptions(): void
    {
        // Create an instance of GameType
        $gameType = new GameType(
            $this->createMock(PlatformsDataTransformer::class),
            $this->createMock(PicturesDataTransformer::class)
        );

        // Create an options resolver
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
            ->method('setDefaults')
            ->with(['data_class' => Game::class]);

        // Call the configureOptions method
        $gameType->configureOptions($resolver);
    }
}
