<?php

namespace App\Repository;

use App\Entity\StatutAdherent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StatutAdherent|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutAdherent|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutAdherent[]    findAll()
 * @method StatutAdherent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutAdherentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StatutAdherent::class);
    }

    // /**
    //  * @return StatutAdherent[] Returns an array of StatutAdherent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatutAdherent
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
