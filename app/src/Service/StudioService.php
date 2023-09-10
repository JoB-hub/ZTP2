<?php
/**
 * Studio service.
 */

namespace App\Service;

use App\Entity\Studio;
use App\Repository\StudioRepository;
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
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param StudioRepository   $studioRepository Studio repository
     * @param PaginatorInterface $paginator        Paginator
     */
    public function __construct(StudioRepository $studioRepository, PaginatorInterface $paginator)
    {
        $this->studioRepository = $studioRepository;
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
}
