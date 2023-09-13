<?php
/**
 * Game entity.
 */

namespace App\Entity;

use App\Repository\GameRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Game class.
 */
#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ORM\Table(name: 'games')]
class Game
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Title.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * Description.
     *
     * @var string|null
     */
    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    /**
     * Created at.
     *
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Timestampable(on: 'create')]
    private ?DateTimeInterface $createdAt = null;

    /**
     * Genre.
     *
     * @var Genre|null
     */
    #[ORM\ManyToOne(targetEntity: Genre::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genre $genre = null;

    /**
     * Studio.
     *
     * @var Studio|null
     */
    #[ORM\ManyToOne(targetEntity: Studio::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Studio $studio = null;

    /**
     * Pic.
     *
     * @var Pic|null
     */
    #[ORM\OneToOne(mappedBy: 'game', cascade: ['persist', 'remove'])]
    private ?Pic $pic = null;

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
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 64)]
    #[Gedmo\Slug(fields: ['title'])]
    private ?string $slug = null;

    /**
     * Author.
     *
     * @var User|null
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
        $this->platforms = new ArrayCollection();
    }

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
     * Getter for title.
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for description.
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter for createdAt.
     *
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for createdAt.
     *
     * @param DateTimeInterface $createdAt
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for genre.
     *
     * @return Genre|null
     */
    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    /**
     * Setter for genre.
     *
     * @param Genre|null $genre
     */
    public function setGenre(?Genre $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * Getter for studio.
     *
     * @return Studio|null
     */
    public function getStudio(): ?Studio
    {
        return $this->studio;
    }

    /**
     * Setter for studio.
     *
     * @param Studio|null $studio
     */
    public function setStudio(?Studio $studio): void
    {
        $this->studio = $studio;
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

    /**
     * Getter for pics.
     *
     * @return Pic|null
     */
    public function getPic(): ?Pic
    {
        return $this->pic;
    }

    /**
     * Setter for pics.
     *
     * @param Pic $pic
     */
    public function setPic(Pic $pic): void
    {
        // set the owning side of the relation if necessary
        if ($pic->getGame() !== $this) {
            $pic->setGame($this);
        }

        $this->pic = $pic;
    }

    /**
     * Getter for slug.
     *
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Setter for slug.
     *
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * Getter for author.
     *
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for author.
     *
     * @param User|null $author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }
}
