<?php
/**
 * Platform service.
 */

namespace App\Service;

use App\Repository\PlatformRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class PlatformService.
 */
class PlatformService implements PlatformServiceInterface
{
    /**
     * Platform repository.
     */
    private PlatformRepository $platformRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param PlatformRepository     $platformRepository Platform repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(PlatformRepository $platformRepository, PaginatorInterface $paginator)
    {
        $this->platformRepository = $platformRepository;
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
            $this->platformRepository->queryAll(),
            $page,
            PlatformRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
