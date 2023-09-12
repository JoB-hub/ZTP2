<?php
/**
 * Studio service interface.
 */

namespace App\Service;

use App\Entity\Studio;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface StudioServiceInterface.
 */
interface StudioServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Studio $studio Category entity
     */
    public function save(Studio $studio): void;

    public function delete(Studio $studio): void;
}
