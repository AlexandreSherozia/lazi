<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 20/02/2019
 * Time: 01:11
 */

namespace App\Service;


use App\Entity\Syndicat;
use Doctrine\ORM\EntityManagerInterface;

class SyndicatManager
{
    private $entityManager;


    /**
     * SyndicatManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Syndicat $syndicat)
    {
        $this->entityManager->persist($syndicat);
        $this->entityManager->flush();

    }
}