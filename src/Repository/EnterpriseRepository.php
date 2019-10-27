<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Departement;
use App\Entity\Entreprise;
use App\Entity\Region;
use App\Model\Search\AdvancedSearch;
use App\Model\Search\SearchCriteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Entreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprise[]    findAll()
 * @method Entreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnterpriseRepository extends ServiceEntityRepository
{
    private $regionRepository;

    public function __construct(RegistryInterface $registry,
                                RegionRepository $regionRepository)
    {
        parent::__construct($registry, Entreprise::class);
        $this->regionRepository = $regionRepository;
    }

    public function getSortedSectors(Entreprise $entreprise): array
    {
        $sortedSectorActivities = [];

        foreach ($entreprise->getActivity() as $secteurActivite) {

            switch ($secteurActivite->getNom()) {
                case 'veaux':
                    $sortedSectorActivities['bovins'][] = $secteurActivite->getNom() . ' - ' . $entreprise->getNombreVeaux();
                    break;
                case 'maigres':
                    $sortedSectorActivities['bovins'][] = $secteurActivite->getNom() . ' - ' . $entreprise->getNombreMaigres();
                    break;
                case 'boucherie':
                    $sortedSectorActivities['bovins'][] = $secteurActivite->getNom() . ' - ' . $entreprise->getNombreBoucherie();
                    break;
                case 'elev.&reprod.':
                    $sortedSectorActivities['bovins'][] = $secteurActivite->getNom() . ' - ' . $entreprise->getNombreElevProd();
                    break;
                case 'ovins':
                    $sortedSectorActivities['autres'][] = $secteurActivite->getNom() . ' - ' . $entreprise->getNombreOvins();
                    break;
                case 'porcins':
                    $sortedSectorActivities['autres'][] = $secteurActivite->getNom() . ' - ' . $entreprise->getNombrePorcins();
                    break;
                case 'equins':
                    $sortedSectorActivities['autres'][] = $secteurActivite->getNom() . ' - ' . $entreprise->getNombreEquins();
                    break;
                case 'caprins':
                    $sortedSectorActivities['autres'][] = $secteurActivite->getNom() . ' - ' . $entreprise->getNombreCaprins();
                    break;
            }
        }
        return $sortedSectorActivities;
    }

    public function getRaisonNonAdhesionFromRepo($id)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :id')
            ->setParameter('id', $id)
            ->select('e.raisonNonAdhesion')
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * stats for DefaultController "Accueil"
     */
    public function getEntrepriseStats(): array
    {
        $entreprisesStat = [];

        $entreprisesStat['total'] = 0 < \count($this->findAll()) ? \count($this->findAll()) : 0;
        $entreprisesStat['negoce'] = 0 < \count($this->findBy(['isTransporter' => false])) ? \count($this->findBy(['isTransporter' => false])) : 0;
        $entreprisesStat['transporter'] = 0 < \count($this->findBy(['isTransporter' => true])) ? \count($this->findBy(['isTransporter' => true])) : 0;

        $entreprisesStat['totalPerRegion'] = $this->countPerRegion();

        return $entreprisesStat;
    }

    private function countPerRegion(): array
    {
        $regions = $this->regionRepository->findAll();

        $entreprisesPerRegion = [];
        $totalRegions = \count($regions) + 1;

        for ($regionId = 1; $regionId < $totalRegions; $regionId++) {

            $entreprisesPerRegion[$regions[$regionId - 1]->getId()] = $this->createQueryBuilder('e')
                ->select('count(e.id)')
                ->andWhere('r.id = :regionId')
                ->setParameter('regionId', $regionId)
                ->leftJoin('e.departement', 'd')
                ->leftJoin('d.regions', 'r')
                ->getQuery()
                ->getSingleScalarResult();
        }
        return $entreprisesPerRegion;
    }

    public function retrieveAllData(AdvancedSearch $advancedSearch, ?string $forEmailSending, ?string $forSmsSending)
    {
        $searchCriterias = $advancedSearch->getSearchCriteria();
        $totalCount = \count($searchCriterias);

        $query = $this->createQueryBuilder('e');
        $joinAliases = ['a', 'b', 'd', 'c', 'f', 'g', 'h', 'ab', 'ac', 'ad', 'ae', 'af', 'ag'];
        $joinAliases2 = ['i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'ia', 'ib', 'ic', 'id', 'ie'];
        $terms = ['term1', 'term2', 'term3', 'term4', 'term5', 'term6', 'term7', 'term8', 'term9', 'term10', 'term11', 'term12'];

        for ($i = 0; $i < $totalCount; $i++) {

            $entity = $searchCriterias[$i]->getEntity();
            $field = $searchCriterias[$i]->getField();
            $term = $searchCriterias[$i]->getTerm();

            $doubleJoin = null;

            $j = $joinAliases[$i];
            $dj = $joinAliases2[$i];

            /*2*/
            $entrRelationPropNames = ['departement', 'syndicat', 'groupeEntreprise', 'activity'];

            switch ($entity) {

                case 'contact':
                    $entity = 'contactResponsable';
                    break;

                case 'cotisation':
                    $entity = 'cotisations';

                    if ('cotisationStatut' === $field) {
                        /*1*/
                        $doubleJoin = $field;
                    } else {
                        $query
                            ->andWhere("$dj.$field =:$terms[$i]")
                            ->setParameter($terms[$i], $term)
                            ->leftJoin("e.$entity", $dj);
                    }
                    break;

                case 'etablissements':

                    if ('departement' === $field) {
                        $doubleJoin = $field;
                    }
                    $field = 'nom';
                    break;
            }

            if ($doubleJoin) {
                $query/*1*/
                ->andWhere("$dj.nom =:term")//Every doubleJoined Entity must have the property "nom"
                ->setParameter('term', $term)
                    ->leftJoin("e.$entity", $j)
                    ->leftJoin("$j.$doubleJoin", $dj);
            } elseif ('entreprise' === $entity) {

                if (\in_array($field, $entrRelationPropNames, true)) {
                    if ('departement' === $field) {
                        $query/*2*/
                        ->andWhere("$j.nom LIKE :$terms[$i]")
                            ->setParameter($terms[$i], '%' . $term . '%')
                            ->leftJoin("e.$field", $j);
                    } else {
                        $query/*2*/
                        ->andWhere("$j.nom =:$terms[$i]")
                            ->setParameter($terms[$i], $term)
                            ->leftJoin("e.$field", $j);
                    }
                } elseif ('numDepart' === $field) {
                    $query/*2*/
                    ->andWhere("$j.$field =:$terms[$i]")
                        ->setParameter($terms[$i], $term)
                        ->leftJoin('e.departement', $j);
                } else {
                    $query
                        ->andWhere("e.$field LIKE :$terms[$i]")
                        ->setParameter($terms[$i], '%' . $term . '%');

                }
            } else {
                $query/*4*/
                ->andWhere("$j.$field LIKE :$terms[$i]")
                    ->setParameter($terms[$i], '%'. $term .'%')
                    ->leftJoin("e.$entity", $j);
            }
        }
        $query->setMaxResults(500);
        return $query->getQuery()->getResult();
    }

    public function extractEtablissementsFromExistingQuery(array $advancedSearchResults): array
    {
        $etablissements = [];

        /** @var Entreprise $entreprise */
        foreach ($advancedSearchResults as $entreprise) {
            if ($entreprise->getEtablissements()) {
                foreach ($entreprise->getEtablissements() as $etablissement) {

                    $nomDepartement = $etablissement->getDepartement() ? $etablissement->getDepartement()->getNom() : 'inconnu';
                    $nomRegion = 'inconnue';
                    if ($etablissement->getDepartement() && $etablissement->getDepartement()->getRegions()) {
                        $nomRegion = $etablissement->getDepartement()->getRegions()[0]->getNom();
                    }

                    if ($etablissement->getSiegeSocial()) {
                        $etablissements[$entreprise->getId()]['siege']['nom'] = $etablissement->getNom();
                        if ($etablissement->getDepartement()) {

                            $etablissements[$entreprise->getId()]['siege']['departementNom'] = $nomDepartement;
                            $etablissements[$entreprise->getId()]['siege']['regionNom'] = $nomRegion;
                        }
                        $etablissements[$entreprise->getId()]['siege']['codeSiren'] = $etablissement->getCodeSiret();
                    } else {
                        $etablissements[$entreprise->getId()]['autres']['nom'] = $etablissement->getNom();
                        $etablissements[$entreprise->getId()]['autres']['departementNom'] = $nomDepartement;
                        $etablissements[$entreprise->getId()]['autres']['regionNom'] = $nomRegion;
                        $etablissements[$entreprise->getId()]['autres']['codeSiren'] = $etablissement->getCodeSiret();
                    }
                }
            }
        }
        return $etablissements;
    }
}
