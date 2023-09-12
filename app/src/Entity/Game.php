<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

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

    /**
     * Created at.
     *
     * @var \DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeInterface $createdAt = null;

    /**
     * Genre.
     */
    #[ORM\ManyToOne(targetEntity: Genre::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genre $genre = null;

    /**
     * Studio.
     */
    #[ORM\ManyToOne(targetEntity: Studio::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Studio $studio = null;

    #[ORM\OneToOne(mappedBy: 'game', cascade: ['persist', 'remove'])]
    private ?Pic $pic = null;

    /**
     * Pictures.
     *
     * @var ArrayCollection<int, Picture>
     */
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Picture::class, inversedBy: 'games', fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    #[ORM\JoinTable(name: 'games_pictures')]
    private Collection $pictures;

    /**
     * Platforms.
     *
     * @var ArrayCollection<int, Platform>
     */
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Platform::class, fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    #[ORM\JoinTable(name: 'games_platforms')]
    private Collection $platforms;

    /**
     * Slug.
     */
    #[ORM\Column(type: 'string', length: 64)]
    #[Gedmo\Slug(fields: ['title'])]
    private ?string $slug = null;

    /**
     * Author.
     */
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type(User::class)]
    private ?User $author;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->platforms = new ArrayCollection();
    }

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
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): void
    {
        $this->genre = $genre;
    }

    public function getStudio(): ?Studio
    {
        return $this->studio;
    }

    public function setStudio(?Studio $studio): void
    {
        $this->studio = $studio;
    }

    /**
     * Getter for pictures.
     *
     * @return Collection<int, Picture> Pictures collection
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    /**
     * Add picture.
     *
     * @param Picture $picture Picture entity
     */
    public function addPicture(Picture $picture): void
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
        }
    }

    /**
     * Remove picture.
     *
     * @param Picture $picture Picture entity
     */
    public function removePicture(Picture $picture): void
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Getter for platforms.
     *
     * @return Collection<int, Platform> Platforms collection
     */
    public function getPlatforms(): Collection
    {
        return $this->platforms;
    }

    /**
     * Add platform.
     *
     * @param Platform $platform Platform entity
     */
    public function addPlatform(Platform $platform): void
    {
        if (!$this->platforms->contains($platform)) {
            $this->platforms[] = $platform;
        }
    }

    /**
     * Remove platform.
     *
     * @param Platform $platform Platform entity
     */
    public function removePlatform(Platform $platform): void
    {
        $this->platforms->removeElement($platform);
    }

    public function getPic(): ?Pic
    {
        return $this->pic;
    }

    public function setPic(Pic $pic): void
    {
        // set the owning side of the relation if necessary
        if ($pic->getGame() !== $this) {
            $pic->setGame($this);
        }

        $this->pic = $pic;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }
}
