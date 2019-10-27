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
	 * @Assert\Image(mimeTypesMessage="asserts.article.image.mimetype",
	 *     maxSize="1M", maxSizeMessage="asserts.article.image.maxsize")
	 */
	private $avatar;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contact", mappedBy="userInterface", cascade={"persist", "remove"})
     */
    private $contact;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $registrationDate;

	/**
	 * @ORM\Column(type="string", length=80)
	 */
	private $token;

    public function __construct()
    {
    	$this->registrationDate = new \DateTime();
    	$this->roles[] = 'ROLE_VISITOR';
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
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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

}
