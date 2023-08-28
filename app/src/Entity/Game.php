<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ORM\Table(name: 'games')]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $users_id = null;

    #[ORM\Column]
    private ?int $genre_id = null;

    #[ORM\Column]
    private ?int $studio_id = null;

    #[ORM\Column(nullable: true)]
    private ?int $picture_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUsersId(): ?int
    {
        return $this->users_id;
    }

    public function setUsersId(?int $users_id): void
    {
        $this->users_id = $users_id;
    }

    public function getGenreId(): ?int
    {
        return $this->genre_id;
    }

    public function setGenreId(int $genre_id): void
    {
        $this->genre_id = $genre_id;
    }

    public function getStudioId(): ?int
    {
        return $this->studio_id;
    }

    public function setStudioId(int $studio_id): void
    {
        $this->studio_id = $studio_id;
    }

    public function getPictureId(): ?int
    {
        return $this->picture_id;
    }

    public function setPictureId(?int $picture_id): void
    {
        $this->picture_id = $picture_id;
    }
}
