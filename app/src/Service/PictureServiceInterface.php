<?php
/**
 * Picture service interface.
 */

namespace App\Service;

use App\Entity\Picture;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface PictureServiceInterface.
 */
interface PictureServiceInterface
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
     * Find by name.
     *
     * @param string $filename Picture filename
     *
     * @return Picture|null Picture entity
     */
    public function findOneByFilename(string $filename): ?Picture;
}
