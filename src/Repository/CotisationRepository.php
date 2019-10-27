<?php

namespace App\Repository;

use App\Entity\Cotisation;
use App\Entity\Entreprise;
use App\Model\Search\AdvancedSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @method Cotisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cotisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cotisation[]    findAll()
 * @method Cotisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CotisationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cotisation::class);
    }

    /**
     * @param AdvancedSearch $advancedSearch
     * @param null|string $forEmailSending
     * @param null|string $forSmsSending
     * @return bool|mixed
     */
    public function retrieveAllData(AdvancedSearch $advancedSearch, ?string $forEmailSending, ?string $forSmsSending)
    {
        $searchCriterias = $advancedSearch->getSearchCriteria();
        $totalCount = \count($searchCriterias);

        $query = $this->createQueryBuilder('c');
        $joinAliases = ['a', 'b', 'd','e', 'f', 'g', 'h','ab','ac','ad','ae','af','ag'];
        $joinAliases2 = ['i','j','k', 'l', 'm', 'n','o','p','ia','ib','ic','id','ie'];
        $terms = ['term1', 'term2', 'term3', 'term4', 'term5', 'term6', 'term7','term8','term9','term10','term11','term12'];

        for ($i = 0; $i < $totalCount; $i++) {

            $entity = $searchCriterias[$i]->getEntity();
            $field = $searchCriterias[$i]->getField();
            $term = $searchCriterias[$i]->getTerm();

            $j=$joinAliases[$i];
            $dj=$joinAliases2[$i];

            $entrRelationPropNames = ['departement', 'syndicat', 'groupeEntreprise', 'activity'];

            if ('cotisation'===$entity) {
                if ('cotisationStatut'===$field) {
                    $query
                        ->andWhere("$j.nom =:term")
                        ->setParameter('term', $term)
                        ->leftJoin('c.cotisationStatut', $j)
                    ;
                } else {
                    $query
                        ->andWhere("c.$field =:$terms[$i]")
                        ->setParameter($terms[$i], $term)
                    ;
                }
            }
            elseif ('entreprise' === $entity) {

                if (\in_array($field,$entrRelationPropNames, true)) {
                    $query
                        ->andWhere("$dj.nom LIKE :$terms[$i]")
                        ->setParameter($terms[$i],'%' .$term. '%')
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin("$j.$field", $dj)
                    ;
                }
                elseif ('numDepart'===$field) {
                    $query
                        ->andWhere("$dj.$field = :$terms[$i]")
                        ->setParameter($terms[$i],$term)
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin("$j.departement", $dj)
                    ;
                }
                else {
                    $query
                        ->andWhere("$j.$field LIKE :term")
                        ->setParameter('term','%' . $term . '%')
                        ->leftJoin('c.entreprise', $j)
                    ;
                }
            }
            elseif ('etablissements'===$entity) {
                if ('departement'===$field){
                    return false;
                }
                $query
                    ->andWhere("$dj.$field LIKE :term")
                    ->setParameter('term', '%' .$term. '%')
                    ->leftJoin('c.entreprise', $j)
                    ->leftJoin("$j.etablissements",$dj)
                ;
            }
            else {
                $query /*4*/
                ->andWhere("$j.$field =:$terms[$i]")
                    ->setParameter($terms[$i], $term)
                    ->leftJoin("c.$entity", $j)
                ;
            }
        }
        return $query->getQuery()->getResult();
    }

    /**
     * Checks Etat Adhesion / Membership state
     * @param Entreprise $entreprise
     * @return mixed
     */
    public function etatAdhesion(Entreprise $entreprise)
    {
        $today = getdate();
        $currentYear = $today['year'];
        $lastYear = $currentYear-1;

        $cotisationLimit = new \DateTime("$currentYear-09-30");
        $now = new \DateTime('NOW');

        $query = $this->createQueryBuilder('c')
            ->andWhere('c.entreprise = :office')
            ->andWhere('cs.nom = :status')
            ->andWhere('cs.nom = :status')
            ->setParameter('office',$entreprise)
            ->setParameter('status','payé')
            ->leftJoin('c.cotisationStatut', 'cs')
        ;

        if ($now <= $cotisationLimit) {
            $query
                ->andWhere('c.anneeCotisation = :year OR c.anneeCotisation = :lastYear')
                ->setParameter('year',$currentYear)
                ->setParameter('lastYear',$lastYear)
            ;
        } else {
            $query
                ->andWhere('c.anneeCotisation = :year')
                ->setParameter('year',$currentYear)
                ;
        }
        return $query->getQuery()->getResult();
    }
}
