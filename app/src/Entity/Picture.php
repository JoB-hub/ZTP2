<?php
/**
 * Picture entity.
 */

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Picture.
 */
#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[ORM\Table(name: 'pictures')]
class Picture
{
    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Filename.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    /**
     * Getter for id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for filename.
     *
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * Setter for filename.
     *
     * @param string $filename
     *
     * @return void
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }
}
