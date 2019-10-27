<?php

namespace App\Repository;

use App\Entity\ConseilAdministration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConseilAdministration|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConseilAdministration|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConseilAdministration[]    findAll()
 * @method ConseilAdministration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConseilAdministrationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConseilAdministration::class);
    }

    // /**
    //  * @return ConseilAdministration[] Returns an array of ConseilAdministration objects
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
    public function findOneBySomeField($value): ?ConseilAdministration
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
