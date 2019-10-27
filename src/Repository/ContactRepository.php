<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Entity\Entreprise;
use App\Model\Search\AdvancedSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{

    /**
     * ContactRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * stats for DefaultController "Accueil"
     */
    public function getContactStats(): array
    {
        $contactStats = [];
        $contactStats['total'] = \count($this->findAll());

        return $contactStats;
    }

    public function getAllLinkedRoles($bureaRoleId)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('b.id =:bureauRoleId')
            ->setParameter('bureauRoleId', $bureaRoleId)
            ->leftJoin('c.bureau', 'b')
            ->getQuery()
            ->getResult();
    }

    public function findAllWithEntreprise()
    {
        $result = $this->createQueryBuilder('c')
            ->select(
                'c.id as contactId, 
                c.prenom, 
                c.nom, 
                c.emailContact, 
                c.telPortable,
                c.isResponsible')//rajouter raisonSocial de l'entreprise pour les privilégié  addSelect
            ->addSelect('e.id as entrepriseId, e.raisonSocial')
            ->leftJoin(Entreprise::class, 'e', 'WITH', 'e.contactResponsable = c')
            ->getQuery()
            ->getResult();

        return $result;

    }

    public function findRelatedEntreprise($contact)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c = :contact')
            ->setParameter('contact', $contact)
            ->select('e.id as entrepriseId, e.raisonSocial')
            ->innerJoin(Entreprise::class, 'e', 'WITH', 'e.contactResponsable = c')
            ->getQuery()
            ->getResult();
    }


    /**
     * @param AdvancedSearch $advancedSearch
     * @param string $forEmailSending
     * @param string $forSmsSending
     * @return mixed
     */
    public function retrieveAllData(AdvancedSearch $advancedSearch, ?string $forEmailSending, ?string $forSmsSending)
    {
        $searchCriterias = $advancedSearch->getSearchCriteria();
        $totalCount = \count($searchCriterias);

        $query = $this->createQueryBuilder('c');
        $joinAliases = ['a', 'b', 'd', 'e', 'f', 'g', 'h', 'ab', 'ac', 'ad', 'ae', 'af', 'ag'];
        $joinAliases2 = ['i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'ia', 'ib', 'ic', 'id', 'ie'];
        $joinAliases3 = ['q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'qr', 'qs', 'qt', 'qu'];
        $terms = ['term1', 'term2', 'term3', 'term4', 'term5', 'term6', 'term7', 'term8', 'term9', 'term10', 'term11', 'term12'];

        $forEmailQuery = 'on' === $forEmailSending ? '%@%' : '%%';
        $forSmsOperator = 'on' === $forSmsSending ? '!=' : 'LIKE';
        $forSmsQuery = 'on' === $forSmsSending ? '' : '%%';

        for ($i = 0; $i < $totalCount; $i++) {

            $entity = $searchCriterias[$i]->getEntity();
            $field = $searchCriterias[$i]->getField();
            $term = $searchCriterias[$i]->getTerm();

            $doubleJoin = null;

            $j = $joinAliases[$i];
            $dj = $joinAliases2[$i];
            $cr = $joinAliases3[$i];
            $crdj = $joinAliases[$i + 2]; //Contact Responsable Double Join

            $entrRelationPropNames = ['departement', 'syndicat', 'groupeEntreprise', 'activity'];
            $contactExtraFieldJoinTables = ['syndicatContacts', 'commissionsContacts', 'contactConseilAdministrations'];

            if ('entreprise' === $entity) {

                if (\in_array($field, $entrRelationPropNames, true)) {
                    $query
                        ->andWhere("$dj.nom LIKE :$terms[$i] OR $crdj.nom LIKE :$terms[$i]")
                        ->setParameter($terms[$i], '%' . $term . '%')
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin('c.entreprises', $cr)
                        ->leftJoin("$j.$field", $dj)
                        ->leftJoin("$cr.$field", $crdj);

                } elseif ('numDepart'===$field) {
                    $query
                        ->andWhere("$dj.$field =:$terms[$i] OR $crdj.nom =:$terms[$i]")
                        ->setParameter($terms[$i], $term)
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin('c.entreprises', $cr)
                        ->leftJoin("$j.departement", $dj)
                        ->leftJoin("$cr.departement", $crdj);
                }

                else {
                    $query
                        ->andWhere("$j.$field LIKE :term OR $cr.$field LIKE :term")
                        ->setParameter('term', '%' . $term . '%')
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin('c.entreprises', $cr);
                }
            } elseif ('etablissements' === $entity) {
                if ('departement' === $field) {
                    $query
                        ->andWhere("$crdj.nom LIKE :term")
                        ->setParameter('term', '%' . $term . '%')
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin("$j.etablissements", $dj)
                        ->leftJoin("$dj.departement", $crdj);
                } elseif ('numDepart' === $field) {
                    $query
                        ->andWhere("$crdj.$field = :term")
                        ->setParameter('term', $term)
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin("$j.etablissements", $dj)
                        ->leftJoin("$dj.departement", $crdj);
                } else {
                    $query
                        ->andWhere("$dj.$field LIKE :term")
                        ->setParameter('term', '%' . $term . '%')
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin("$j.etablissements", $dj);
                }
            } elseif ('syndicat' === $entity) {
                $query
                    ->andWhere("$dj.nom LIKE :$terms[$i]")
                    ->setParameter($terms[$i], '%' . $term . '%')
                    ->leftJoin('c.syndicatContacts', $j)
                    ->leftJoin("$j.syndicat", $dj);
            } elseif ('cotisation' === $entity) {
                if ('cotisationStatut' === $field) {
                    $query
                        ->andWhere("$cr.nom LIKE :$terms[$i]")
                        ->setParameter($terms[$i], '%' . $term . '%')
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin("$j.cotisations", $dj)
                        ->leftJoin("$dj.$field", $cr);
                } else {
                    $query
                        ->andWhere("$dj.$field =:$terms[$i]")
                        ->setParameter($terms[$i], $term)
                        ->leftJoin('c.entreprise', $j)
                        ->leftJoin("$j.cotisations", $dj);
                }
            } elseif ('repere' === $entity) {
                $query
                    ->andWhere("$j.nom LIKE :$terms[$i]")
                    ->setParameter($terms[$i], '%' . $term . '%')
                    ->leftJoin('c.repere', $j);

            } elseif ('contact' === $entity) {
                if ('roleEntreprise' === $field && ('isResponsible'=== $term || 'isPrivileged'===$term)) {
                    $query
                        ->andWhere("c.$term = :$terms[$i]")
                        ->setParameter($terms[$i], true);
                } elseif (\in_array($field,$contactExtraFieldJoinTables,true)) {
                    $attribute = '';
                    switch ($field) {
                        case 'syndicatContacts':
                            $doubleJoin = 'roles'; $attribute = 'nom';
                            break;
                        case 'commissionsContacts':
                            $doubleJoin = 'commissionRoles'; $attribute = 'nom';
                            break;
                        case 'contactConseilAdministrations':
                            $doubleJoin = 'conseilAdministration'; $attribute = 'role';
                            break;
                    }
                    $query
                        ->andWhere("$dj.$attribute LIKE :$terms[$i]")
                        ->setParameter($terms[$i], '%' . $term . '%')
                        ->leftJoin("c.$field", $j)
                        ->leftJoin("$j.$doubleJoin", $dj);
                }else {
                    $query
                        ->andWhere("c.$field LIKE :$terms[$i]")
                        ->setParameter($terms[$i], '%' . $term . '%');
                }
            }
        }
        //This ("default")part of $query checks whether checkboxes "Pour l'envoi d'Email " or "Pour l'envoi de SMS" are checked.
        // if "on", it selects all contacts having emails or phone numbers
        // Impossible for both to be checked simultaneously !
        $query
            ->andWhere('c.emailContact LIKE :email')
            ->setParameter('email', $forEmailQuery)
            ->andWhere("c.telPortable $forSmsOperator :cell")
            ->setParameter('cell', $forSmsQuery)
            ;

        $query->setMaxResults(500);
        return $query->getQuery()->getResult();
    }

    //For ajax request for autocompletion/ unused !
    public function findEmailContainingString(string $suggestion)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.emailContact =:email')
            ->setParameter('email', $suggestion)
//            ->select('c.emailContact')
            ->getQuery()
            ->getResult();
    }
}
