<?php
/**
 * Studio repository.
 */

namespace App\Repository;

use App\Entity\Studio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Studio>
 *
 * @method Studio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Studio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Studio[]    findAll()
 * @method Studio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudioRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Studio::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('studio.id', 'DESC');
    }

    /**
     * Save entity.
     *
     * @param Studio $studio Studio entity
     */
    public function save(Studio $studio): void
    {
        $this->_em->persist($studio);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Studio $category Studio entity
     */
    public function delete(Studio $category): void
    {
        $this->_em->remove($category);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('studio');
    }
}
