<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 15/03/2019
 * Time: 15:23
 */

namespace App\Model\Search;


use Symfony\Component\Validator\Constraints as Assert;

class SearchCriteria
{
    private $advancedSearch;
    /**
     * @Assert\NotBlank(message="Sélectionnez le critère Entité")
     */
    private $entity;
    /**
     * @Assert\NotBlank(message="Sélectionnez le critère Champ")
     */
    private $field;
    /**
     * @Assert\NotBlank(message="Entrez une valeur")
     */
    private $term;

    /**
     * @return mixed
     */
    public function getAdvancedSearch()
    {
        return $this->advancedSearch;
    }

    /**
     * @param mixed $advancedSearch
     * @return SearchCriteria
     */
    public function setAdvancedSearch(AdvancedSearch $advancedSearch): SearchCriteria
    {
        $this->advancedSearch = $advancedSearch;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     * @return SearchCriteria
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     * @return SearchCriteria
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param mixed $term
     * @return SearchCriteria
     */
    public function setTerm($term)
    {
        $this->term = $term;
        return $this;
    }
}
