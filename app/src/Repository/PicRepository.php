<?php

namespace App\Repository;

use App\Entity\Pic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pic>
 *
 * @method Pic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pic[]    findAll()
 * @method Pic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pic::class);
    }

    /**
     * Save entity.
     *
     * @param Pic $pic Pic entity
     */
    public function save(Pic $pic): void
    {
        $this->_em->persist($pic);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Pic $pic Pic entity
     */
    public function delete(Pic $pic): void
    {
        $this->_em->remove($pic);
        $this->_em->flush();
    }
}
