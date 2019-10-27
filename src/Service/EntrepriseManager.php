<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 21/01/2019
 * Time: 13:29
 */

namespace App\Service;


use App\Entity\Commission;
use App\Entity\Contact;
use App\Entity\Entreprise;
use App\Entity\Etablissement;
use App\Entity\GroupeEntreprise;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class EntrepriseManager
{
    private $em, $entrepriseRepository, $userConnexion,$userPasswordEncoder;

    /**
     * EntrepriseManager constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->em = $em;
        $this->entrepriseRepository = $em->getRepository(Entreprise::class);
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * Allows Etablissement adding after the first one has been created
     *
     * @param Etablissement $etablissement
     * @param Entreprise $entreprise
     */
    public function createOtherEtablissement(Etablissement $etablissement,Entreprise $entreprise): void
    {
        $entreprise->addEtablissement($etablissement);
        $this->em->persist($entreprise);
        $this->em->flush();
    }

    /**
     * @param Entreprise $entreprise
     * @param $raisonNonAdhesion
     * @param null $contact
     * @return Entreprise
     */
    public function create(Entreprise $entreprise, $raisonNonAdhesion, $contact = null): Entreprise
    {
        $entreprise->setRaisonNonAdhesion($raisonNonAdhesion);

        foreach ($entreprise->getCommissionEntreprises() as $commissionEntreprise) {
            $commissionEntreprise->setEntreprise($entreprise);
        }
        $entreprise->setEtablissementExists(true);

        $this->userConnexion = new User();
        //Checks if "ContactResponsable" already exists, on "entreprise" edition doesn't create a new User
        if (null !== $entreprise->contactResponsableExists()) {
            $this->userConnexion = $entreprise->getContactResponsable()->getUserInterface();
        }
        /*$connectedResponsible = $this->createConnectedUser($entreprise, $this->userConnexion);
        $this->em->persist($connectedResponsible);*/

        if ($contact) {
            $entreprise->getContactResponsable()->setIsResponsible(false);
            $entreprise->setContactResponsable($contact);
            /** @var Contact $contact */
            $contact->setIsResponsible(true);
        }

        $this->em->persist($entreprise);
        $this->em->flush();

        return $entreprise;
    }

    /**
     * Creates user connexion from "Contact Responsable" / disabled for the moment !
     *
     * @param Entreprise $entreprise
     * @return User
     */
    private function createConnectedUser(Entreprise $entreprise, User $user): User
    {
        if ($entreprise->getContactResponsable()) {

            $login = $entreprise->getContactResponsable()->getEmailContact();
            $user->setEmail($login);
            $user->setFirstName($entreprise->getContactResponsable()->getPrenom());
            $user->setLastName($entreprise->getContactResponsable()->getNom());
            $user->setRoles($user->getRoles());
            $user->setPassword($this->userPasswordEncoder->encodePassword($user,'ffcb'));
            //rajouter aussi un rôle approprié

            $entreprise->setContactResponsableExists(true);

            $user->setContact($entreprise->getContactResponsable());
        }
        return $this->userConnexion;
    }

    public function removeEtablissement(int $entrepriseId, Etablissement $etablissement): void
    {
        $entreprise = $this->entrepriseRepository->find($entrepriseId);

        if ($etablissement) {
            $entreprise->removeEtablissement($etablissement);
        }
        $this->em->persist($entreprise);
        $this->em->flush();
    }


    public function removeEntreprise(int $entrepriseId): void
    {
        $entreprise = $this->entrepriseRepository->find($entrepriseId);
        $this->em->remove($entreprise);
        $this->em->flush();
    }

}