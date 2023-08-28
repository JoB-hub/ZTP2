<?php

namespace App\Entity;

use App\Repository\GamePlatformRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GamePlatformRepository::class)]
#[ORM\Table(name: 'games_platforms')]
class GamePlatform
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $games_id = null;

    #[ORM\Column]
    private ?int $platform_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGamesId(): ?int
    {
        return $this->games_id;
    }

    public function setGamesId(int $games_id): void
    {
        $this->games_id = $games_id;
    }

    public function getPlatformId(): ?int
    {
        return $this->platform_id;
    }

    public function setPlatformId(int $platform_id): void
    {
        $this->platform_id = $platform_id;
    }
}
