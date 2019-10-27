<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 27/05/2019
 * Time: 19:35
 */

namespace App\Service;


use App\Entity\SmsApiParams;
use Doctrine\ORM\EntityManagerInterface;

class SmsApiParamsManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * SmsApiParamsManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(SmsApiParams $smsApiParams)
    {
        $this->entityManager->persist($smsApiParams);
        $this->entityManager->flush();
    }
}