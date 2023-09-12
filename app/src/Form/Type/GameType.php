<?php
/**
 * Game type.
 */

namespace App\Form\Type;

use App\Entity\Genre;
use App\Entity\Game;
use App\Entity\Studio;
use App\Form\DataTransformer\PlatformsDataTransformer;
use App\Form\DataTransformer\PicturesDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Class GameType.
 */
class GameType extends AbstractType
{
    /**
     * Platforms data transformer.
     */
    private PlatformsDataTransformer $platformsDataTransformer;

    /**
     * Pictures data transformer.
     */
    private PicturesDataTransformer $picturesDataTransformer;

    /**
     * Constructor.
     *
     * @param PlatformsDataTransformer $platformsDataTransformer Platforms data transformer
     */
    public function __construct(PlatformsDataTransformer $platformsDataTransformer, PicturesDataTransformer $picturesDataTransformer)
    {
        $this->platformsDataTransformer = $platformsDataTransformer;
        $this->picturesDataTransformer = $picturesDataTransformer;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label.title',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );
        $builder->add(
            'description',
            TextType::class,
            [
                'label' => 'label.description',
                'required' => true,
                'attr' => ['max_length' => 1000],
            ]
        );
        $builder->add(
            'genre',
            EntityType::class,
            [
                'class' => Genre::class,
                'choice_label' => function ($genre): string {
                    return $genre->getName();
                },
                'label' => 'label.genre',
                'placeholder' => 'label.none',
                'required' => true,
            ]
        );
        $builder->add(
            'studio',
            EntityType::class,
            [
                'class' => Studio::class,
                'choice_label' => function ($studio): string {
                    return $studio->getName();
                },
                'label' => 'label.studio',
                'placeholder' => 'label.none',
                'required' => true,
            ]
        );
        $builder->add(
            'pictures',
            TextType::class,
            [
                'label' => 'label.pictures',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );

        $builder->get('pictures')->addModelTransformer(
            $this->picturesDataTransformer
        );
        $builder->add(
            'platforms',
            TextType::class,
            [
                'label' => 'label.platforms',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );
        $builder->get('platforms')->addModelTransformer(
            $this->platformsDataTransformer
        );
        $builder->add(
            'file',
            FileType::class,
            [
                'mapped' => false,
                'label' => 'label.pic',
                'required' => true,
                'constraints' => new Image(
                    [
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/pjpeg',
                            'image/jpeg',
                            'image/pjpeg',
                        ],
                    ]
                ),
            ]
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Game::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'game';
    }
}
