<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Cet Email existe déjà !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * @Assert\Length(max="80", maxMessage="asserts.email.toolong")
     * @Assert\NotBlank(message="asserts.email.notblank")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     * @Assert\NotBlank(message="Vous devez assigner un droit !")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Entrez le prénom d'utilisateur")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Un mot de passe est requis !")
     * @Assert\Length(min="8",minMessage="More than 8 characters, please!")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Entrez le nom de famille")
     */
    private $lastName;

	/**
	 * @ORM\Column(type="string", length=180, nullable=true)
	 * @Assert\Image(mimeTypesMessage="Le format de la photo ne correspond pas",
	 *     maxSize="1M", maxSizeMessage="L'image est supérieure à 1Mo")
	 */
	private $avatar;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contact", mappedBy="userInterface", cascade={"persist", "remove"})
     */
    private $contact;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @Assert\NotBlank(message="Date de naissance est obligatoire !")
	 */
	private $registrationDate;

	/**
	 * @ORM\Column(type="string", length=80)
	 */
	private $token;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="author", orphanRemoval=true)
     */
    private $adverts;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Gedmo\Slug(fields={"firstName", "lastName"}, unique=true, separator="-")
	 */
	private $slug;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\NotBlank(message="Numéro de téléphone est obligatoire !")
     */
    private $mobile;

	public function __construct()
         	{
         		$this->registrationDate = new \DateTime();
         		$this->roles[]          = 'ROLE_VISITOR';
         		$this->adverts          = new ArrayCollection();
         	}

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): ?array
    {
		return $this->roles;
    }

    public function addRole(string $role): self
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using bcrypt or argon
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    //relates contact with user / unused for the moment
    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        // set (or unset) the owning side of the relation if necessary
        $newUserInterface = $contact === null ? null : $this;
        if ($newUserInterface !== $contact->getUserInterface()) {
            $contact->setUserInterface($newUserInterface);
        }

        return $this;
    }

    public static function loadValidatorMetaData(ClassMetadata $classMetadata): void
    {
        $classMetadata->addPropertyConstraint('email', new Assert\NotBlank());
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

	/**
	 * @return mixed
	 */
	public function getToken()
         	{
         		return $this->token;
         	}

	/**
	 * @param mixed $token
	 */
	public function setToken($token): void
         	{
         		$this->token = $token;
         	}

	/**
	 * @return mixed
	 */
	public function getRegistrationDate()
         	{
         		return $this->registrationDate;
         	}

	/**
	 * @param mixed $registrationDate
	 */
	public function setRegistrationDate($registrationDate): void
         	{
         		$this->registrationDate = $registrationDate;
         	}

	/**
	 * @return mixed
	 */
	public function getAvatar()
         	{
         		return $this->avatar;
         	}

	/**
	 * @param mixed $avatar
	 */
	public function setAvatar($avatar): void
         	{
         		$this->avatar = $avatar;
         	}

    /**
     * @return Collection|Advert[]
     */
    public function getAdverts(): Collection
    {
        return $this->adverts;
    }

    public function addAdvert(Advert $advert): self
    {
        if (!$this->adverts->contains($advert)) {
            $this->adverts[] = $advert;
            $advert->setAuthor($this);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->contains($advert)) {
            $this->adverts->removeElement($advert);
            // set the owning side to null (unless already changed)
            if ($advert->getAuthor() === $this) {
                $advert->setAuthor(null);
            }
        }

        return $this;
    }

	/**
	 * @param mixed $slug
	 *
	 * @return User
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	public function getMobile(): ?string
	{
		return $this->mobile;
	}

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

	public function isEnabled()
	{
		$roles = $this->getRoles();

		return \in_array('ROLE_USER', $roles, true);
	}

	public function isSuperAdmin()
	{
		$roles = $this->getRoles();

		return \in_array('ROLE_SUPER_ADMIN', $roles,true);
	}
}
