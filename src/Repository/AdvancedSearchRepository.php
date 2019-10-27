<?php

namespace App\Repository;

use App\Entity\AdvancedSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdvancedSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdvancedSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdvancedSearch[]    findAll()
 * @method AdvancedSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvancedSearchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdvancedSearch::class);
    }

    // /**
    //  * @return AdvancedSearch[] Returns an array of AdvancedSearch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdvancedSearch
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
