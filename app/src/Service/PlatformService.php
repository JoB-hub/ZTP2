<?php
/**
 * Platform service.
 */

namespace App\Service;

use App\Entity\Platform;
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
     * @param PlatformRepository $platformRepository Platform repository
     * @param PaginatorInterface $paginator          Paginator
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

    /**
     * Save entity.
     *
     * @param Platform $platform Platform entity
     */
    public function save(Platform $platform): void
    {
        $this->platformRepository->save($platform);
    }

    /**
     * Delete entity.
     *
     * @param Platform $platform Platform entity
     */
    public function delete(Platform $platform): void
    {
        $this->platformRepository->delete($platform);
    }

    /**
     * Can Platform be deleted?
     *
     * @param Platform $platform Platform entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Platform $platform): bool
    {
        return true;
    }

    /**
     * Find by title.
     *
     * @param string $name Platform title
     *
     * @return Platform|null Platform entity
     */
    public function findOneByName(string $name): ?Platform
    {
        return $this->platformRepository->findOneByName($name);
    }
}
