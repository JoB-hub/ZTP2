<?php
/**
 * Platform service interface.
 */

namespace App\Service;

use App\Entity\Platform;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface PlatformServiceInterface.
 */
interface PlatformServiceInterface
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
     * @param Platform $platform Platform entity
     */
    public function save(Platform $platform): void;

    /**
     * Delete entity.
     *
     * @param Platform $platform
     *
     * @return void
     */
    public function delete(Platform $platform): void;
}
