<?php
/**
 * Pictures data transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Picture;
use App\Service\PictureServiceInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class PicturesDataTransformer.
 *
 * @implements DataTransformerInterface<mixed, mixed>
 */
class PicturesDataTransformer implements DataTransformerInterface
{
    /**
     * Picture service.
     */
    private PictureServiceInterface $pictureService;

    /**
     * Constructor.
     *
     * @param PictureServiceInterface $pictureService Picture service
     */
    public function __construct(PictureServiceInterface $pictureService)
    {
        $this->pictureService = $pictureService;
    }

    /**
     * Transform array of pictures to string of picture filenames.
     *
     * @param Collection<int, Picture> $value Pictures entity collection
     *
     * @return string Result
     */
    public function transform($value): string
    {
        if ($value->isEmpty()) {
            return '';
        }

        $pictureNames = [];

        foreach ($value as $picture) {
            $pictureNames[] = $picture->getFilename();
        }

        return implode(', ', $pictureNames);
    }

    /**
     * Transform string of picture names into array of Picture entities.
     *
     * @param string $value String of picture names
     *
     * @return array<int, Picture> Result
     */
    public function reverseTransform($value): array
    {
        $pictureNames = explode(',', $value);

        $pictures = [];

        foreach ($pictureNames as $pictureName) {
            if ('' !== trim($pictureName)) {
                $picture = $this->pictureService->findOneByFilename(strtolower($pictureName));
                if (null === $picture) {
                    $picture = new Picture();
                    $picture->setFilename($pictureName);

                    $this->pictureService->save($picture);
                }
                $pictures[] = $picture;
            }
        }

        return $pictures;
    }
}
