<?php

namespace App\Repository;

use App\Entity\CotisationStatut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CotisationStatut|null find($id, $lockMode = null, $lockVersion = null)
 * @method CotisationStatut|null findOneBy(array $criteria, array $orderBy = null)
 * @method CotisationStatut[]    findAll()
 * @method CotisationStatut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CotisationStatutRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CotisationStatut::class);
    }

    // /**
    //  * @return CotisationStatut[] Returns an array of CotisationStatut objects
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
    public function findOneBySomeField($value): ?CotisationStatut
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
