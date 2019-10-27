<?php

namespace App\Repository;

use App\Entity\GroupeEntreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GroupeEntreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeEntreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeEntreprise[]    findAll()
 * @method GroupeEntreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeEntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GroupeEntreprise::class);
    }

    // /**
    //  * @return GroupeEntreprise[] Returns an array of GroupeEntreprise objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupeEntreprise
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
