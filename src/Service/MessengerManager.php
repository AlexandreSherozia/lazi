<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 26/04/2019
 * Time: 16:01
 */

namespace App\Service;


use App\Entity\Messenger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class MessengerManager
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

    public function execute(Messenger $messenger, $header='', $content=''): void
    {
        //default recording for History
        $messenger->setSenderEmail($this->connectedUser->getUser()->getEmail());
        $messenger->setSenderName($this->connectedUser->getUser()->getFirstName().' '.$this->connectedUser->getUser()->getLastName());
        $messenger->setSenderFrom($messenger->getSenderFrom());

        //$header and $content arguments are required when we record a model;
        // In other way it's recorded automatically in history via sendEmail action(MailController)
        if ($header || $content) {
            $messenger->setMessageHeader($header);
            $messenger->setMessageBody($content);
            $messenger->setIsDraft(true);
        }

        $this->em->persist($messenger);
        $this->em->flush();
    }

    public function delete(Messenger $model): void
    {
        $this->em->remove($model);
        $this->em->flush();
    }
}
