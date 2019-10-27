<?php

namespace App\Repository;

use App\Entity\ContactBureau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContactBureau|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactBureau|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactBureau[]    findAll()
 * @method ContactBureau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactBureauRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactBureau::class);
    }

    // /**
    //  * @return ContactBureau[] Returns an array of ContactBureau objects
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
    public function findOneBySomeField($value): ?ContactBureau
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
