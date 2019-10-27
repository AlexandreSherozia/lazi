<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 22/01/2019
 * Time: 18:54
 */

namespace App\Form\Handler;


use App\Entity\Contact;
use App\Entity\ContactBureau;
use App\Entity\SyndicatContact;
use App\Service\ContactManager;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactHandler
{
    private $contactManager;

    /**
     * ContactHandler constructor.
     * @param ContactManager $contactManager
     */
    public function __construct(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;
    }

    /**
     * @param Form $form
     * @param Request $request
     * @param ArrayCollection|null $syndicatcontacts
     * @param ArrayCollection|null $commissionContacts
     * @param ArrayCollection|null $contactConseilAdmins
     * @return bool
     */
    public function handle(Form $form, Request $request, ?ArrayCollection $syndicatcontacts=null, ?ArrayCollection $commissionContacts=null, ?ArrayCollection $contactConseilAdmins=null): bool
    {
        /** @var Contact $contact */
        $contact = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//dd($contact->getBureau());
            $this->contactManager->completeContact($contact, $syndicatcontacts, $commissionContacts, $contactConseilAdmins);

            return true;
        }
        return false;
    }

}