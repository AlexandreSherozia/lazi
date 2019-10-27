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
     *
     */
    private $typeContact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Nom requis")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Prénom requis")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Portable requis")
     */
    private $telPortable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telPortable2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telBureau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Email requis")
     */
    private $emailContact;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $codePostal;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="contact", cascade={"persist", "remove"})
     */
    private $userInterface;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Repere", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $repere;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Repere", inversedBy="contacts")
     * @ORM\JoinTable(name="contact_reperes")
     */
    private $reperesExistants;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $civilite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="author")
     */
    private $advert;

    public function __construct()
    {
        $this->repere = new ArrayCollection();
        $this->reperesExistants = new ArrayCollection();
        $this->advert = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeContact(): ?string
    {
        return $this->typeContact;
    }

    public function setTypeContact(string $typeContact): self
    {
        $this->typeContact = $typeContact;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelPortable(): ?string
    {
        return $this->telPortable;
    }

    public function setTelPortable(?string $telPortable): self
    {
        $this->telPortable = $telPortable;

        return $this;
    }

    public function getTelBureau(): ?string
    {
        return $this->telBureau;
    }

    public function setTelBureau(?string $telBureau): self
    {
        $this->telBureau = $telBureau;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    /**
     * @return mixed
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param mixed $dateNaissance
     * @return Contact
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function setEmailContact(?string $emailContact): self
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }


    /**
     * @return Collection|Repere[]
     */
    public function getRepere(): Collection
    {
        return $this->repere;
    }

    public function addRepere(Repere $repere): self
    {
        if (!$this->repere->contains($repere)) {
            $this->repere[] = $repere;
        }

        return $this;
    }

    public function removeRepere(Repere $repere): self
    {
        if ($this->repere->contains($repere)) {
            $this->repere->removeElement($repere);
        }

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }


    public function getUserInterface(): ?User
    {
        return $this->userInterface;
    }

    public function setUserInterface(?User $userInterface): self
    {
        $this->userInterface = $userInterface;

        return $this;
    }



    /**
     * @return Collection|Repere[]
     */
    public function getReperesExistants(): Collection
    {
        return $this->reperesExistants;
    }

    public function addReperesExistant(Repere $reperesExistant): self
    {
        if (!$this->reperesExistants->contains($reperesExistant)) {
            $this->reperesExistants[] = $reperesExistant;
        }

        return $this;
    }

    public function removeReperesExistant(Repere $reperesExistant): self
    {
        if ($this->reperesExistants->contains($reperesExistant)) {
            $this->reperesExistants->removeElement($reperesExistant);
        }

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(?string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }


    public function getTelPortable2(): ?string
    {
        return $this->telPortable2;
    }

    public function setTelPortable2(?string $telPortable2): self
    {
        $this->telPortable2 = $telPortable2;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    /**
     * @return Collection|Advert[]
     */
    public function getAdvert(): Collection
    {
        return $this->advert;
    }

    public function addAdvert(Advert $advert): self
    {
        if (!$this->advert->contains($advert)) {
            $this->advert[] = $advert;
            $advert->setAuthor($this);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        if ($this->advert->contains($advert)) {
            $this->advert->removeElement($advert);
            // set the owning side to null (unless already changed)
            if ($advert->getAuthor() === $this) {
                $advert->setAuthor(null);
            }
        }

        return $this;
    }
}
