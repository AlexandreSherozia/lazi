<?php

namespace App\Repository;

use App\Entity\Departement;
use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Region|null find($id, $lockMode = null, $lockVersion = null)
 * @method Region|null findOneBy(array $criteria, array $orderBy = null)
 * @method Region[]    findAll()
 * @method Region[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegionRepository extends ServiceEntityRepository
{
    private $departementRepository;

    public function __construct(RegistryInterface $registry, DepartementRepository $departementRepository)
    {
        parent::__construct($registry, Region::class);

        $this->departementRepository = $departementRepository;
    }

    public function getRegionsWithDepartments()
    {
//        $departements = $this->departementRepository->findAll();
//        $total = \count($departements);

        $regions = [];

            $regions[] = $this->createQueryBuilder('r')
                ->addSelect('d.nom')
                ->leftJoin('r.departements', 'd')
                ->getQuery()
                ->getResult()
            ;
//        }

//        foreach ($departements as $departement) {



        return $regions;
    }


    // /**
    //  * @return Region[] Returns an array of Region objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Region
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
