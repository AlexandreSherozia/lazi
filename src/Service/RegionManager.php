<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 27/02/2019
 * Time: 23:38
 */

namespace App\Service;


use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;

class RegionManager
{
    private $entityManager;

    /**
     * RegionManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Region $region)
    {
        foreach ($region->getDepartements() as $departement) {

            $departement->addRegion($region);
        }
        $this->entityManager->persist($region);
        $this->entityManager->flush();
    }
}