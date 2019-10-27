<?php

namespace App\Repository;

use App\Entity\EntrepriseCommission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EntrepriseCommission|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntrepriseCommission|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntrepriseCommission[]    findAll()
 * @method EntrepriseCommission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseCommissionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EntrepriseCommission::class);
    }

    // /**
    //  * @return EntrepriseCommission[] Returns an array of EntrepriseCommission objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EntrepriseCommission
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
