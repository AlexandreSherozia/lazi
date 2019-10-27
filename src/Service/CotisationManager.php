<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 06/02/2019
 * Time: 12:45
 */

namespace App\Service;


use App\Entity\Cotisation;
use App\Entity\Entreprise;
use App\Repository\EnterpriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class CotisationManager
{
    private $entityManager;
    /**
     * @var EntrepriseManager
     */
    private $entrepriseManager;
    /**
     * @var EnterpriseRepository
     */
    private $enterpriseRepository;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * CotisationManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param FlashBagInterface $flashBag
     * @param RouterInterface $router
     */
    public function __construct(EntityManagerInterface $entityManager,
                                FlashBagInterface $flashBag
                                )
    {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    public function create(Cotisation $cotisation, Entreprise $entreprise)
    {

        $this->flashBag->add(
            'success', 'Le statut "'.$cotisation->getCotisationStatut()->getNom().'" a bien été défini pour l\'entreprise "'.
            $cotisation->getEntreprise()->getRaisonSocial().'" !' //rajouter "pour l'année un tel" !!
        );
        $entreprise->addCotisation($cotisation);
        $this->entityManager->persist($cotisation);
        $this->entityManager->flush();

        return true;
    }

    public function editCotisation(Cotisation $cotisation, Entreprise $entreprise)
    {
        $entreprise->addCotisation($cotisation);
        $this->entityManager->persist($cotisation);
        $this->entityManager->flush();

        $this->flashBag->add(
            'success', '"'.$cotisation->getEntreprise()->getRaisonSocial().'" : '
            .\strtoupper($cotisation->getCotisationStatut()->getNom())
            .' défini pour l\'année '.$cotisation->getAnneeCotisation().' !'
        );
    }
}