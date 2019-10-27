<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 08/03/2019
 * Time: 11:47
 */

namespace App\Service;


use App\Entity\Bureau;
use App\Entity\Roles;
use Doctrine\ORM\EntityManagerInterface;

class RolesManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * RolesManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Roles $roles)
    {
        $this->entityManager->persist($roles);
        $this->entityManager->flush();
    }

    public function remove(Roles $role)
    {
        $this->entityManager->remove($role);
        $this->entityManager->flush();
    }
}