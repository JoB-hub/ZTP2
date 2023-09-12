<?php
/**
 * Pic entity.
 */

namespace App\Entity;

use App\Repository\PicRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Pic.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: PicRepository::class)]
#[ORM\Table(name: 'pics')]
class Pic
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Game.
     */
    #[ORM\OneToOne(inversedBy: 'pic', targetEntity: Game::class, cascade: ['persist', 'remove'], fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type(Game::class)]
    private ?Game $game = null;

    /**
     * Filename.
     */
    #[ORM\Column(type: 'string', length: 191)]
    #[Assert\Type('string')]
    private ?string $filename = null;

    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for game.
     *
     * @return Game|null Game
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

    /**
     * Setter for game.
     *
     * @param Game|null $game Game
     */
    public function setGame(?Game $game): void
    {
        $this->game = $game;
    }

    /**
     * Getter for filename.
     *
     * @return string|null Filename
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * Setter for filename.
     *
     * @param string|null $filename Filename
     */
    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }
}
