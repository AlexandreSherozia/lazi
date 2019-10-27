<?php

namespace App\Repository;

use App\Entity\ContactConseilAdministration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContactConseilAdministration|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactConseilAdministration|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactConseilAdministration[]    findAll()
 * @method ContactConseilAdministration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactConseilAdministrationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactConseilAdministration::class);
    }

    // /**
    //  * @return ContactConseilAdministration[] Returns an array of ContactConseilAdministration objects
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
    public function findOneBySomeField($value): ?ContactConseilAdministration
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
