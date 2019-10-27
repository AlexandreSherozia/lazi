<?php

namespace App\Repository;

use App\Entity\CommissionContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommissionContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommissionContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommissionContact[]    findAll()
 * @method CommissionContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommissionContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommissionContact::class);
    }

    public function getAllLinkedCommissionRoles($commissionRoleId)
    {
        return $this->createQueryBuilder('cc')
            ->andWhere('r.id = :roleId')
            ->setParameter('roleId', $commissionRoleId)
            ->leftJoin('cc.commissionRoles', 'r')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return CommissionContact[] Returns an array of CommissionContact objects
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
    public function findOneBySomeField($value): ?CommissionContact
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
