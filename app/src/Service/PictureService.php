<?php
/**
 * Picture service.
 */

namespace App\Service;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class PictureService.
 */
class PictureService implements PictureServiceInterface
{
    /**
     * Picture repository.
     */
    private PictureRepository $pictureRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param PictureRepository  $pictureRepository Picture repository
     * @param PaginatorInterface $paginator         Paginator
     */
    public function __construct(PictureRepository $pictureRepository, PaginatorInterface $paginator)
    {
        $this->pictureRepository = $pictureRepository;
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
            $this->pictureRepository->queryAll(),
            $page,
            PictureRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Picture $picture Picture entity
     */
    public function save(Picture $picture): void
    {
        $this->pictureRepository->save($picture);
    }

    /**
     * Delete entity.
     *
     * @param Picture $picture Picture entity
     */
    public function delete(Picture $picture): void
    {
        $this->pictureRepository->delete($picture);
    }

    /**
     * Find by title.
     *
     * @param string $filename Picture filename
     *
     * @return Picture|null Picture entity
     */
    public function findOneByFilename(string $filename): ?Picture
    {
        return $this->pictureRepository->findOneByFilename($filename);
    }
}
