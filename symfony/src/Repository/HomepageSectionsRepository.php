<?php

namespace App\Repository;

use App\Entity\HomepageSections;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HomepageSections|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomepageSections|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomepageSections[]    findAll()
 * @method HomepageSections[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomepageSectionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomepageSections::class);
    }

    // /**
    //  * @return HomepageSections[] Returns an array of HomepageSections objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HomepageSections
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
