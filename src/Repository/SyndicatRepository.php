<?php

namespace App\Repository;

use App\Entity\Syndicat;
use App\Model\Search\AdvancedSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Syndicat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Syndicat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Syndicat[]    findAll()
 * @method Syndicat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SyndicatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Syndicat::class);
    }

    /**
     * @param AdvancedSearch $advancedSearch
     * @param null|string $forEmailSending
     * @param null|string $forSmsSending
     * @return mixed
     */
    public function retrieveAllData(AdvancedSearch $advancedSearch, ?string $forEmailSending, ?string $forSmsSending)
    {

        $searchCriterias = $advancedSearch->getSearchCriteria();
        $totalCount = \count($searchCriterias);

        $query = $this->createQueryBuilder('s');
        $joinAliases = ['a', 'b', 'd','e', 'f', 'g', 'h','ab','ac','ad','ae','af','ag'];
        $joinAliases2 = ['i','j','k', 'l', 'm', 'n','o','p','ia','ib','ic','id','ie'];
        $terms = ['term1', 'term2', 'term3', 'term4', 'term5', 'term6', 'term7','term8','term9','term10','term11','term12'];

        for ($i = 0; $i < $totalCount; $i++) {

            $entity = $searchCriterias[$i]->getEntity();
            $field = $searchCriterias[$i]->getField();
            $term = $searchCriterias[$i]->getTerm();

            $j=$joinAliases[$i];
            $dj=$joinAliases2[$i];

            if ('syndicat'===$entity) {
                if ('departement'===$field) {
                    $query
                        ->andWhere("$j.nom LIKE :term")
                        ->setParameter('term', '%' .$term. '%')
                        ->leftJoin('s.departement', $j)
                    ;
                }
                elseif ('numDepart'===$field) {
                    $query
                        ->andWhere("$j.numDepart = :term")
                        ->setParameter('term', $term)
                        ->leftJoin('s.departement', $j)
                    ;
                }
                elseif ('region'===$field) {
                    $query
                        ->andWhere("$dj.nom LIKE :term")
                        ->setParameter('term', '%' .$term. '%')
                        ->leftJoin('s.departement', $j)
                        ->leftJoin("$j.regions", $dj)
                    ;
                } else {
                    $query
                        ->andWhere("s.$field LIKE :$terms[$i]")
                        ->setParameter($terms[$i],'%' .$term. '%')
                    ;
                }
            }
            /*elseif ('entreprise' === $entity) {

                if (\in_array($field,$entrRelationPropNames, true)) {
                    $query
                        ->andWhere("$dj.nom LIKE :$terms[$i]")
                        ->setParameter($terms[$i],'%' .$term. '%')
                        ->leftJoin('s.entreprise', $j)
                        ->leftJoin("$j.$field", $dj)
                    ;
                } else {
                    $query
                        ->andWhere("$j.$field =:term")
                        ->setParameter('term', $term)
                        ->leftJoin('s.entreprise', $j)
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
                    ->leftJoin('s.entreprise', $j)
                    ->leftJoin("$j.etablissements",$dj)
                ;
            }*/
            else {
                $query /*4*/
                ->andWhere("$j.$field =:$terms[$i]")
                    ->setParameter($terms[$i], $term)
                    ->leftJoin("s.$entity", $j)
                ;
            }
        }
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Syndicat[] Returns an array of Syndicat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Syndicat
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
