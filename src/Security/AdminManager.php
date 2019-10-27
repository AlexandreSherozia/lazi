<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 01/02/2019
 * Time: 10:00
 */

namespace App\Security;


use App\Entity\Bureau;
use App\Entity\Commission;
use App\Entity\CommissionRole;
use App\Entity\ConseilAdministration;
use App\Entity\Departement;
use App\Entity\GroupeEntreprise;
use App\Entity\TypeOffre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class AdminManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * AdminManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param FlashBagInterface $flashBag
     */
    public function __construct(EntityManagerInterface $entityManager, FlashBagInterface $flashBag)
    {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    public function create(GroupeEntreprise $groupeEntreprise)
    {
        $this->flashBag->set('success', 'Le groupe "' . $groupeEntreprise->getNom() . '" a bien été créé !');
        $this->entityManager->persist($groupeEntreprise);
        $this->entityManager->flush();
    }

    public function removeGroup(GroupeEntreprise $groupeEntreprise): void
    {
        $this->entityManager->remove($groupeEntreprise);
        $this->entityManager->flush();
    }

    public function createCommission(Commission $commission): void
    {
        $this->entityManager->persist($commission);
        $this->entityManager->flush();
    }

    public function createCommissionRole(CommissionRole $commissionRole): void
    {
        $this->entityManager->persist($commissionRole);
        $this->entityManager->flush();
    }

    public function removeCommission(Commission $commission): void
    {
        $this->entityManager->remove($commission);
        $this->entityManager->flush();
    }
    public function removeCommissionRole(CommissionRole $commissionRole): void
    {
        $this->entityManager->remove($commissionRole);
        $this->entityManager->flush();
    }

    public function removeDepartment(Departement $departement): void
    {
        $this->entityManager->remove($departement);
        $this->entityManager->flush();
    }

    public function createConseilAdministration(ConseilAdministration $conseilAdministration): void
    {
        $this->entityManager->persist($conseilAdministration);
        $this->entityManager->flush();
    }

    public function removeConseilAdministration(ConseilAdministration $conseilAdministration): void
    {
        $this->entityManager->remove($conseilAdministration);
        $this->entityManager->flush();
    }

    public function createOffer(TypeOffre $typeOffer): void
    {
        $this->entityManager->persist($typeOffer);
        $this->entityManager->flush();
    }

    public function removeOffer(TypeOffre $typeOffer): void
    {
        $this->entityManager->remove($typeOffer);
        $this->entityManager->flush();
    }
}