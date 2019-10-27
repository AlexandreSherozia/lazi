<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 15/03/2019
 * Time: 14:30
 */

namespace App\Model\Search;


use Doctrine\Common\Collections\ArrayCollection;

class AdvancedSearch
{
    private $searchCriterias;
    private $entityFormType;
    private $isForEmailSending;
    private $isForSmsSending;

    /**
     * @return mixed
     */
    public function getisForEmailSending()
    {
        return $this->isForEmailSending;
    }

    /**
     * @param mixed $isForEmailSending
     * @return AdvancedSearch
     */
    public function setIsForEmailSending($isForEmailSending)
    {
        $this->isForEmailSending = $isForEmailSending;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getisForSmsSending()
    {
        return $this->isForSmsSending;
    }

    /**
     * @param mixed $isForSmsSending
     * @return AdvancedSearch
     */
    public function setIsForSmsSending($isForSmsSending)
    {
        $this->isForSmsSending = $isForSmsSending;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntityFormType()
    {
        return $this->entityFormType;
    }

    /**
     * @param mixed $entityFormType
     */
    public function setEntityFormType($entityFormType): void
    {
        $this->entityFormType = $entityFormType;
    }

    /**
     * AdvancedSearch constructor.
     */
    public function __construct()
    {
        $this->searchCriterias = new ArrayCollection();
    }

    public function  addSearchCriterium(SearchCriteria $searchCriteria)
    {
        $this->searchCriterias[] = $searchCriteria;

        return $this;
    }

    public function getSearchCriteria()
    {
        return $this->searchCriterias;
    }

    public function removeSearchCriterium(SearchCriteria $searchCriteria): void
    {
        $this->searchCriterias->removeElement($searchCriteria);
    }

}