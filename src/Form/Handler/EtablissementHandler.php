<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 26/01/2019
 * Time: 11:39
 */

namespace App\Form\Handler;


use App\Entity\Etablissement;
use App\Service\EntrepriseManager;
use App\Service\EtablissementManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class EtablissementHandler
{
    private $form;
    private $request;
    private $etablissementManager;
    private $entrepriseManager;

    /**
     * EtablissementHandler constructor.
     * @param $form
     * @param $request
     * @param $etablissementManager
     */
    public function __construct(EtablissementManager $etablissementManager,
                                EntrepriseManager $entrepriseManager)
    {
        $this->etablissementManager = $etablissementManager;
        $this->entrepriseManager = $entrepriseManager;
    }

    public function handle(Form $form, Request $request, $entreprise)
    {
        /** @var Etablissement $etablissement */
        $etablissement = $form->getData();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entrepriseManager->createOtherEtablissement($etablissement,$entreprise);
            return true;
        }
        return false;
    }
}
