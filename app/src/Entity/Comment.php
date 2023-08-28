<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\Table(name: 'comments')]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $users_id = null;

    #[ORM\Column]
    private ?int $games_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getUsersId(): ?int
    {
        return $this->users_id;
    }

    public function setUsersId(int $users_id): void
    {
        $this->users_id = $users_id;
    }

    public function getGamesId(): ?int
    {
        return $this->games_id;
    }

    public function setGamesId(int $games_id): void
    {
        $this->games_id = $games_id;
    }
}
