<?php

namespace App\Repository;

use App\Entity\SmsApiParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmsApiParams|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmsApiParams|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmsApiParams[]    findAll()
 * @method SmsApiParams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmsApiParamsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmsApiParams::class);
    }

    // /**
    //  * @return SmsApiParams[] Returns an array of SmsApiParams objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SmsApiParams
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
