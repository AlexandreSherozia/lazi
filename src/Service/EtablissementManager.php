<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 25/01/2019
 * Time: 15:03
 */

namespace App\Service;


use App\Entity\Entreprise;
use App\Entity\Etablissement;
use App\Repository\EtablissementRepository;
use Doctrine\ORM\EntityManagerInterface;

class EtablissementManager
{

    private $em, $etablissement, $etablissementRepository;

    /**
     * EtablissementManager constructor.
     * @param $em
     * @param $etablissementRepository
     */
    public function __construct(EntityManagerInterface $em, EtablissementRepository $etablissementRepository)
    {
        $this->em = $em;
        $this->etablissementRepository = $etablissementRepository;
    }

    /**
     * @param Entreprise $entreprise
     * @return Etablissement|null
     * Creates only one instance of Etablissement
     */
    public function createEtablissement(Entreprise $entreprise): ?Etablissement
    {
        $this->etablissement = new Etablissement();
        $this->etablissement->setAdresse($entreprise->getAdresse());
        $this->etablissement->setVille($entreprise->getVille());
        $this->etablissement->setDepartement($entreprise->getDepartement());
        $this->etablissement->setSyndicat($entreprise->getSyndicat());
        $this->etablissement->setNom($entreprise->getRaisonSocial());
        $this->etablissement->setTelBureau1($entreprise->getTel1());
        $this->etablissement->setTelBureau2($entreprise->getTel2());
        $this->etablissement->setEmailBureau($entreprise->getEmail());
        $this->etablissement->setFax($entreprise->getFax());
        $this->etablissement->setCodeSiret($entreprise->getCodeSiren()); // siret ou siren ????????????
        $this->etablissement->setCodePostal($entreprise->getCodePostal());
        $this->etablissement->setSiegeSocial(true);
        $this->etablissement->setEntreprise($entreprise);

        $this->em->persist($this->etablissement);
        return $this->etablissement;
    }

    public function getEtablissement(int $etablissementId): ?Etablissement
    {
        return $this->etablissementRepository->find($etablissementId);
    }


}