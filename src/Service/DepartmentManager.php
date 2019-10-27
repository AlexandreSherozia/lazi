<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 04/03/2019
 * Time: 15:29
 */

namespace App\Service;


use App\Entity\Departement;
use Doctrine\ORM\EntityManagerInterface;

class DepartmentManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * DepartmentManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Departement $departement)
    {
        $this->entityManager->persist($departement);
        $this->entityManager->flush();
    }
}