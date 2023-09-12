<?php
/**
 * Platforms data transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Platform;
use App\Service\PlatformServiceInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class PlatformsDataTransformer.
 *
 * @implements DataTransformerInterface<mixed, mixed>
 */
class PlatformsDataTransformer implements DataTransformerInterface
{
    /**
     * Platform service.
     */
    private PlatformServiceInterface $platformService;

    /**
     * Constructor.
     *
     * @param PlatformServiceInterface $platformService Platform service
     */
    public function __construct(PlatformServiceInterface $platformService)
    {
        $this->platformService = $platformService;
    }

    /**
     * Transform array of platforms to string of platform titles.
     *
     * @param Collection<int, Platform> $value Platforms entity collection
     *
     * @return string Result
     */
    public function transform($value): string
    {
        if ($value->isEmpty()) {
            return '';
        }

        $platformNames = [];

        foreach ($value as $platform) {
            $platformNames[] = $platform->getName();
        }

        return implode(', ', $platformNames);
    }

    /**
     * Transform string of platform names into array of Platform entities.
     *
     * @param string $value String of platform names
     *
     * @return array<int, Platform> Result
     */
    public function reverseTransform($value): array
    {
        $platformNames = explode(',', $value);

        $platforms = [];

        foreach ($platformNames as $platformName) {
            if ('' !== trim($platformName)) {
                $platform = $this->platformService->findOneByName(strtolower($platformName));
                if (null === $platform) {
                    $platform = new Platform();
                    $platform->setName($platformName);

                    $this->platformService->save($platform);
                }
                $platforms[] = $platform;
            }
        }

        return $platforms;
    }
}
