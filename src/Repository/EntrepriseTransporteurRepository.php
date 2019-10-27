<?php

namespace App\Repository;

use App\Entity\EntrepriseTransporteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EntrepriseTransporteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntrepriseTransporteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntrepriseTransporteur[]    findAll()
 * @method EntrepriseTransporteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseTransporteurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EntrepriseTransporteur::class);
    }

    // /**
    //  * @return EntrepriseTransporteur[] Returns an array of EntrepriseTransporteur objects
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
    public function findOneBySomeField($value): ?EntrepriseTransporteur
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
