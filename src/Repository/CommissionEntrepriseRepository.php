<?php

namespace App\Repository;

use App\Entity\CommissionEntreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommissionEntreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommissionEntreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommissionEntreprise[]    findAll()
 * @method CommissionEntreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommissionEntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommissionEntreprise::class);
    }

    // /**
    //  * @return CommissionEntreprise[] Returns an array of CommissionEntreprise objects
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
    public function findOneBySomeField($value): ?CommissionEntreprise
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
