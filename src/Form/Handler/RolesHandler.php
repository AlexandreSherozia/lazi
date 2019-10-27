<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 08/03/2019
 * Time: 11:45
 */

namespace App\Form\Handler;


use App\Service\RolesManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class RolesHandler
{
    /**
     * @var RolesManager
     */
    private $rolesManager;

    /**
     * RolesHandler constructor.
     * @param RolesManager $rolesManager
     */
    public function __construct(RolesManager $rolesManager)
    {
        $this->rolesManager = $rolesManager;
    }

    public function handle(Form $form, Request $request)
    {
        $roles = $form->getData();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->rolesManager->create($roles);
            return true;
        }
        return false;
    }
}