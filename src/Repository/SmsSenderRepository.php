<?php

namespace App\Repository;

use App\Entity\SmsSender;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmsSender|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmsSender|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmsSender[]    findAll()
 * @method SmsSender[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmsSenderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmsSender::class);
    }

    // /**
    //  * @return SmsSender[] Returns an array of SmsSender objects
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
    public function findOneBySomeField($value): ?SmsSender
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
