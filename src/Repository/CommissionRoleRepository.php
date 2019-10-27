<?php

namespace App\Repository;

use App\Entity\CommissionRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommissionRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommissionRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommissionRole[]    findAll()
 * @method CommissionRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommissionRoleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommissionRole::class);
    }

    // /**
    //  * @return CommissionRole[] Returns an array of CommissionRole objects
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
    public function findOneBySomeField($value): ?CommissionRole
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
