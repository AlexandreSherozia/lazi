<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 24/05/2019
 * Time: 11:12
 */

namespace App\Service;


use App\Entity\SmsSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class SmsSenderManager
{
    private $em;
    /**
     * @var Security
     */
    private $connectedUser;

    /**
     * ContactManager constructor.
     * @param EntityManagerInterface $em
     * @param Security $connectedUser
     */
    public function __construct(EntityManagerInterface $em, Security $connectedUser)
    {
        $this->em = $em;
        $this->connectedUser = $connectedUser;
    }

    public function execute(SmsSender $smsSender, $content=''): void
    {
        $smsSender->setSenderFrom($this->connectedUser->getUser()->getFirstName().' '.$this->connectedUser->getUser()->getLastName());

        //$header and $content are required when we record a model;
        // In other way it's recorded automatically in history via sendEmail action(MailController)
        if ($content) {
            $smsSender->setMessage($content);
            $smsSender->setIsDraft(true);
        }

        $this->em->persist($smsSender);
        $this->em->flush();
    }

    public function delete(SmsSender $model): void
    {
        $this->em->remove($model);
        $this->em->flush();
    }
}