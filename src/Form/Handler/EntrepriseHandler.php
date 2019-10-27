<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 21/01/2019
 * Time: 13:24
 */

namespace App\Form\Handler;


use App\Entity\Contact;
use App\Entity\Entreprise;
use App\Repository\EnterpriseRepository;
use App\Service\EntrepriseManager;
use App\Service\EtablissementManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class EntrepriseHandler
{
    private $form;
    private $request;
    private $entrepriseManager;
    private $etablissementManager;
    private $contactResponsable;
    private $enterpriseRepository;

    /**
     * EntrepriseHandler constructor.
     * @param EntrepriseManager $entrepriseManager
     * @param EtablissementManager $etablissementManager
     * @param EnterpriseRepository $enterpriseRepository
     */
    public function __construct(EntrepriseManager $entrepriseManager,
                                EtablissementManager $etablissementManager ,
                                EnterpriseRepository $enterpriseRepository)
    {
        $this->entrepriseManager = $entrepriseManager;
        $this->etablissementManager = $etablissementManager;
        $this->enterpriseRepository = $enterpriseRepository;
    }


    public function handle(Form $form, Request $request, string $action): ?bool
    {
        $this->form = $form;
        $this->request = $request;
        /** @var Entreprise $entreprise */
        $entreprise = $this->form->getData();

        $this->form->handleRequest($this->request);
        if ($this->form->isSubmitted() && $this->form->isValid()) {

            /* if contactResponsible is selected "from DBB" */
            if ($this->form['contactResponsableList']->getData()) {
                $this->contactResponsable = $this->form['contactResponsableList']->getData();
            }

            $this->onSubmitted($entreprise, $this->contactResponsable, $action);
            return true;
        }
        return false;
    }

    /**
     * Provides AdvertController with the advert creation form
     *
     * @return Form
     */
    public function getForm():Form
    {
        return $this->form;
    }

    /**
     * @param Entreprise $entreprise
     * @param Contact $contact
     * @param $action
     */
    protected function onSubmitted(Entreprise $entreprise, ?Contact $contact, $action): void
    {
        $raisonNonAdhesion = $this->getRaisonNonAdhesionOption($entreprise, $action);

        //Only first creation of Etablissement
        if (null === $entreprise->etablissementExists()) {
            $this->etablissementManager->createEtablissement($entreprise);
        }

        $this->entrepriseManager->create($entreprise, $raisonNonAdhesion, $contact);

    }

    private function getRaisonNonAdhesionOption(Entreprise $entreprise, string $action)
    {
        if("Changement de secteur d'activité" === $this->form->get('raisonNonAdhesion')->getData())  {

            $raisonNonAdhesion = $this->form->get('raisonNonAdhesion')->getData();

        } elseif ("Cessation d'activité depuis le" === $this->form->get('raisonNonAdhesion')->getData()) {

            $raisonNonAdhesion = $this->form->get('raisonNonAdhesion')->getData() . ': ' . $this->form->get('radioButtonInput')->getData();

            //If while editing, raisonNonAdhesion is not modified, the same value will be set
        } elseif ('edit' === $action && null === $this->form->get('raisonNonAdhesion')->getData()) {

                //gets existing raisonNonAdhesion string
                $raisonNonAdhesion = $this->enterpriseRepository->getRaisonNonAdhesionFromRepo($entreprise->getId())['raisonNonAdhesion'];

        } else {
            //if "Autre Raison" by Textarea
            $raisonNonAdhesion = $this->form->get('radioButtonTextarea')->getData();
        }

        return $raisonNonAdhesion;
    }
}