<?php
/**
 * Genre service.
 */

namespace App\Service;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class GenreService.
 */
class GenreService implements GenreServiceInterface
{
    /**
     * Genre repository.
     */
    private GenreRepository $genreRepository;

    /**
     * Game repository.
     */
    #[ORM\Column(type: 'string')]
    private GameRepository $gameRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param GenreRepository    $genreRepository Genre repository
     * @param PaginatorInterface $paginator       Paginator
     */
    public function __construct(GenreRepository $genreRepository, GameRepository $gameRepository, PaginatorInterface $paginator)
    {
        $this->genreRepository = $genreRepository;
        $this->gameRepository = $gameRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->genreRepository->queryAll(),
            $page,
            GenreRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Genre $genre Genre entity
     */
    public function save(Genre $genre): void
    {
        $this->genreRepository->save($genre);
    }

    /**
     * Delete entity.
     *
     * @param Genre $genre Genre entity
     */
    public function delete(Genre $genre): void
    {
        $this->genreRepository->delete($genre);
    }

    /**
     * Can Genre be deleted?
     *
     * @param Genre $genre Genre entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Genre $genre): bool
    {
        try {
            $result = $this->gameRepository->countByGenre($genre);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }
}
