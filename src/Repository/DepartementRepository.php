<?php

namespace App\Repository;

use App\Entity\Departement;
use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Departement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departement[]    findAll()
 * @method Departement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Departement::class);
    }

    public function getRegionsWithDepartments(): array
    {
        $regionsWithDeparts = [];

        $regions = $this->createQueryBuilder('d')
            ->select('d.nom as departName, d.numDepart as numeroDepart, d.id as departId')
            ->addSelect('r.nom as regionName, r.id as regionId')
            ->leftJoin('d.regions', 'r')
            ->getQuery()
            ->getResult()
        ;

        foreach ($regions as $region) {
            $regionsWithDeparts[$region['regionName']][] = $region;
            }
        return $regionsWithDeparts;
    }

    public function getDepartmentsWithRegion()
    {
        Return $this->createQueryBuilder('d')
            ->select('d.nom as departName, d.id, d.numDepart')
            ->addSelect('r.nom as regionName')
            ->leftJoin('d.regions', 'r')
            ->groupBy('d.nom')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Departement[] Returns an array of Departement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Departement
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
