<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 22/01/2019
 * Time: 18:56
 */

namespace App\Service;


use App\Entity\CommissionContact;
use App\Entity\Contact;
use App\Entity\ContactConseilAdministration;
use App\Entity\SyndicatContact;
use App\Repository\ContactRepository;
use App\Repository\SyndicatContactRepository;
use App\Repository\SyndicatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ContactManager
{
    private $em;

    /**
     * ContactManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function completeContact(Contact $contact,$syndicatcontacts,$commissionContacts,$contactConseilAdmins): void
    {
        foreach ($contact->getContactConseilAdministrations() as $bureau) {
            $bureau->setContact($contact);
        }
        foreach ($contact->getCommissionsContacts() as $commissionsContact) {
            $commissionsContact->setContact($contact);
        }

        foreach ($contact->getSyndicatContacts() as $sc) {

            if (null === $sc->getSyndicat()) {
                /** @var SyndicatContact $syndicatcontact */
                foreach ($syndicatcontacts as $syndicatcontact) {

                    $sc->setSyndicat($syndicatcontact->getSyndicat());
                    foreach ($syndicatcontact->getRoles() as $role) {
//                        dd($role);
                        $role->addSyndicatContact($sc);
                        $sc->addRole($role);
                        $this->em->persist($sc);
                        $this->em->persist($role);
                    }
                }
                $sc->setIsActive(false);
                $sc->setContact($contact);
                $sc->setDateFin(new \DateTime());
//                    $syndicatContact->setSyndicat();
            }
            elseif (!$sc->getIsActive()){
                $sc->setDateFin($sc->getDateFin());
            }
            else {
                $sc->setIsActive(true);
                $sc->setDateFin(null);
            }
        }

        /* COMMISSION_CONTACT */
        foreach ($contact->getCommissionsContacts() as $cc) {

            if (null === $cc->getCommission()) {
                        /** @var CommissionContact $commissionContact */
                foreach ($commissionContacts as $commissionContact) {

                    $cc->setCommission($commissionContact->getCommission());
                    foreach ($commissionContact->getCommissionRoles() as $role) {
//                        dd($role);
                        $role->addCommissionContact($cc);
                        $cc->addCommissionRole($role);
                        $this->em->persist($cc);
                        $this->em->persist($role);
                    }
                }
                $cc->setIsActive(false);
                $cc->setContact($contact);
                $cc->setDateFin(new \DateTime());
//                    $syndicatContact->setSyndicat();
            }
            elseif (!$cc->getIsActive()){
                $cc->setDateFin($cc->getDateFin());
            }
            else {
                $cc->setIsActive(true);
                $cc->setDateFin(null);
            }
        }


        $count = \count($contact->getContactConseilAdministrations());
        $cca = $contact->getContactConseilAdministrations();

        /* CONSEIL_ADMINISTRATION */  /** @var ContactConseilAdministration $cca */
        for ($i = 0; $i<$count; $i++) {

                //If we try to Delete the item
                if (null === $cca[$i]->getConseilAdministration()) {
//                dd('Disabling');
                    //If we "delete", in fact we set the old value for save in history
                    $cca[$i]->setConseilAdministration($contactConseilAdmins[$i]->getConseilAdministration());
                    $cca[$i]->setDateDebut($contactConseilAdmins[$i]->getDateDebut());


                    $cca[$i]->setIsInactif(true);
                    $cca[$i]->setIsActive(false);
                    //... and we set the end time
                    $cca[$i]->setDateFin(new \DateTime());

                } elseif ($cca[$i]->getIsActive()) {
//                    dd('Actif');
                    $cca[$i]->setDateDebut($contactConseilAdmins[$i]->getDateDebut());
                } elseif ($cca[$i]->getIsInactif()) {
//                    dd('Inactif !');
                    // If we create an item
                    $cca[$i]->setDateFin($contactConseilAdmins[$i]->getDateFin());
                    $cca[$i]->setDateDebut($contactConseilAdmins[$i]->getDateDebut());
                } else {
//                    dd('New !');
                    $cca[$i]->setIsActive(true);
                    $cca[$i]->setIsInactif(false);
                    $cca[$i]->setDateDebut(new \DateTime());
                }

        }
        $contact->setIsResponsible(false);

        $this->em->persist($contact);
        $this->em->flush();
    }

}