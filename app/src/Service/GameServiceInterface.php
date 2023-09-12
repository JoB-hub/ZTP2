<?php
/**
 * Game service interface.
 */

namespace App\Service;

use App\Entity\Game;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface GameServiceInterface.
 */
interface GameServiceInterface
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
     * @param Game $game Game entity
     */
    public function save(Game $game): void;

    /**
     * Delete entity.
     *
     * @param Game $game Game entity
     */
    public function delete(Game $game): void;
}
