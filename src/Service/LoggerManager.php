<?php


/**
 * Created by PhpStorm.
 * User: pc
 * Date: 13/03/2019
 * Time: 12:33
 */

namespace App\Service;


use App\Entity\Logger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class LoggerManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $connectedUser;

    /**
     * LoggerManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->connectedUser = $security;
    }

    public function log(string $entityName,string $objectName, string $action): void
    {
        $logger = new Logger();

        $logger->setSender($this->connectedUser->getUser()->getFirstName().' '.$this->connectedUser->getUser()->getLastName());
        $logger->setEntityName($entityName);
        $logger->setObjectName($objectName);
        $logger->setAction($action);
        $logger->setDatetime($logger->getDatetime());

        $this->entityManager->persist($logger);
        $this->entityManager->flush();
    }
}