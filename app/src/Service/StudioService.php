<?php
/**
 * Studio service.
 */

namespace App\Service;

use App\Entity\Studio;
use App\Repository\GameRepository;
use App\Repository\StudioRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Mapping as ORM;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class StudioService.
 */
class StudioService implements StudioServiceInterface
{
    /**
     * Studio repository.
     */
    private StudioRepository $studioRepository;

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
     * @param StudioRepository   $studioRepository Studio repository
     * @param PaginatorInterface $paginator        Paginator
     * @param GameRepository     $gameRepository   Game repository
     */
    public function __construct(StudioRepository $studioRepository, PaginatorInterface $paginator, GameRepository $gameRepository)
    {
        $this->studioRepository = $studioRepository;
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
            $this->studioRepository->queryAll(),
            $page,
            StudioRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Studio $studio Studio entity
     */
    public function save(Studio $studio): void
    {
        $this->studioRepository->save($studio);
    }

    /**
     * Delete entity.
     *
     * @param Studio $studio Studio entity
     */
    public function delete(Studio $studio): void
    {
        $this->studioRepository->delete($studio);
    }

    /**
     * Can Studio be deleted?
     *
     * @param Studio $studio Studio entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Studio $studio): bool
    {
        try {
            $result = $this->gameRepository->countByStudio($studio);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }
}
