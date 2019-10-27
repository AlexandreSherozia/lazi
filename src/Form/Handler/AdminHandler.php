<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 01/02/2019
 * Time: 09:59
 */

namespace App\Form\Handler;


use App\Entity\GroupeEntreprise;
use App\Entity\User;
use App\Security\AdminManager;
use App\Service\UserManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class AdminHandler
{
    private $adminManager;
    private $userManager;

    /**
     * AdminHandler constructor.
     * @param AdminManager $adminManager
     * @param UserManager $userManager
     */
    public function __construct(AdminManager $adminManager, UserManager $userManager)
    {
        $this->adminManager = $adminManager;
        $this->userManager = $userManager;
    }

    /**
     * HANDLER FOR GroupeEntrepriseType
     * @param Form $form
     * @param Request $request
     * @return bool
     */
    public function handleGroupeEntreprise(Form $form, Request $request): bool
    {
        /** @var GroupeEntreprise $groupeEntreprise */
        $groupeEntreprise = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->adminManager->create($groupeEntreprise);

            return true;
        }
        return false;
    }

    /**
     * @param Form $form
     * @param Request $request
     * @return bool
     */
    public function handleUser(Form $form, Request $request): bool
    {
        /** @var User $groupeEntreprise */
        $user = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->create($user);

            return true;
        }
        return false;
    }

    public function handleCommission(Form $form, Request $request): bool
    {
        $commission = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->adminManager->createCommission($commission);
            return true;
        }
        return false;
    }

    public function handleCommissionRole(Form $form, Request $request): bool
    {
        $commissionRole = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->adminManager->createCommissionRole($commissionRole);
            return true;
        }
        return false;
    }

    public function handleRoleConseil(Form $form, Request $request): bool
    {
        $conseilAdmin = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->adminManager->createConseilAdministration($conseilAdmin);
            return true;
        }
        return false;
    }

    public function handleTypeOffre(Form $form, Request $request): bool
    {
        $typeOffre = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->adminManager->createOffer($typeOffre);
            return true;
        }
        return false;
    }
}
