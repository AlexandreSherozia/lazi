<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailContact;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

	/**
	 * @ORM\Column(type="string", length=60, nullable=true)
	 */
	private $zipCode;


	/**
	 * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="contact", cascade={"persist", "remove"})
	 */
	private $userInterface;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $civility;


	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getMobile2()
	{
		return $this->mobile2;
	}

	/**
	 * @param mixed $mobile2
	 */
	public function setMobile2($mobile2): void
	{
		$this->mobile2 = $mobile2;
	}

	/**
	 * @return mixed
	 */
	public function getEmailContact()
	{
		return $this->emailContact;
	}

	/**
	 * @param mixed $emailContact
	 */
	public function setEmailContact($emailContact): void
	{
		$this->emailContact = $emailContact;
	}

	/**
	 * @return mixed
	 */
	public function getBirthDate()
	{
		return $this->birthDate;
	}

	/**
	 * @param mixed $birthDate
	 */
	public function setBirthDate($birthDate): void
	{
		$this->birthDate = $birthDate;
	}

	/**
	 * @return mixed
	 */
	public function getCommentaire()
	{
		return $this->commentaire;
	}

	/**
	 * @param mixed $commentaire
	 */
	public function setCommentaire($commentaire): void
	{
		$this->commentaire = $commentaire;
	}

	/**
	 * @return mixed
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @param mixed $address
	 */
	public function setAddress($address): void
	{
		$this->address = $address;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param mixed $city
	 */
	public function setCity($city): void
	{
		$this->city = $city;
	}

	/**
	 * @return mixed
	 */
	public function getZipCode()
	{
		return $this->zipCode;
	}

	/**
	 * @param mixed $zipCode
	 */
	public function setZipCode($zipCode): void
	{
		$this->zipCode = $zipCode;
	}

	/**
	 * @return mixed
	 */
	public function getUserInterface()
	{
		return $this->userInterface;
	}

	/**
	 * @param mixed $userInterface
	 */
	public function setUserInterface($userInterface): void
	{
		$this->userInterface = $userInterface;
	}

	/**
	 * @return mixed
	 */
	public function getCivility()
	{
		return $this->civility;
	}

	/**
	 * @param mixed $civility
	 */
	public function setCivility($civility): void
	{
		$this->civility = $civility;
	}
}
