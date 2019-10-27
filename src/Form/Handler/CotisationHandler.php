<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 06/02/2019
 * Time: 12:39
 */

namespace App\Form\Handler;


use App\Entity\Cotisation;
use App\Service\CotisationManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class CotisationHandler
{
    private $cotisationManager;

    /**
     * CotisationHandler constructor.
     * @param CotisationManager $cotisationManager
     */
    public function __construct(CotisationManager $cotisationManager)
    {
        $this->cotisationManager = $cotisationManager;
    }

    public function handle(Form $form, Request $request, string $action)
    {

        /** @var Cotisation $cotisation */
        $cotisation = $form->getData();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ('create' === $action) {
                $this->cotisationManager->create($cotisation, $cotisation->getEntreprise());

                return true;
            }
            $this->cotisationManager->editCotisation($cotisation, $cotisation->getEntreprise());

            return true;
        }
        return false;
    }
}