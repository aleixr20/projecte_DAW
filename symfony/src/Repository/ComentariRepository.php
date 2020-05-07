<?php

namespace App\Repository;

use App\Entity\Comentari;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comentari|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comentari|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comentari[]    findAll()
 * @method Comentari[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentariRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comentari::class);
    }

    // /**
    //  * @return Comentari[] Returns an array of Comentari objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comentari
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
