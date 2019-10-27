<?php

namespace App\Repository;

use App\Entity\SyndicatContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SyndicatContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method SyndicatContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method SyndicatContact[]    findAll()
 * @method SyndicatContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SyndicatContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SyndicatContact::class);
    }

    public function getAllLinkedRoles($roleId)
    {
        return $this->createQueryBuilder('sc')
            ->andWhere('r.id =:roleId')
            ->setParameter('roleId', $roleId)
            ->leftJoin('sc.roles', 'r')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return SyndicatContact[] Returns an array of SyndicatContact objects
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
    public function findOneBySomeField($value): ?SyndicatContact
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
