<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessengerRepository")
 */
class Messenger
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message="Ce champ doit contenir un seul email valide !")
     *
     */
    private $senderEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $messageHeader;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     *
     */
    private $messageBody;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $senderName;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDraft;

    /**
     * @Assert\Email(message="L'adresse n'est pas conforme au format d'email")
     */
    private $recipientEmail;

    /**
     * @Assert\Email(message="L'adresse n'est pas conforme au format d'email")
     */
    private $ccRecipientEmail;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message="L'adresse n'est pas conforme au format d'email")
     */
    private $senderFrom;

    /**
     * Messenger constructor.
     */
    public function __construct()
    {
        $this->datetime = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getCcRecipientEmail()
    {
        return $this->ccRecipientEmail;
    }

    /**
     * @param mixed $ccRecipientEmail
     * @return Messenger
     */
    public function setCcRecipientEmail($ccRecipientEmail): Messenger
    {
        $this->ccRecipientEmail = $ccRecipientEmail;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSenderEmail(): ?string
    {
        return $this->senderEmail;
    }

    public function setSenderEmail(string $senderEmail): self
    {
        $this->senderEmail = $senderEmail;

        return $this;
    }

    public function getMessageHeader(): ?string
    {
        return $this->messageHeader;
    }

    public function setMessageHeader(string $messageHeader): self
    {
        $this->messageHeader = $messageHeader;

        return $this;
    }

    public function getMessageBody(): ?string
    {
        return $this->messageBody;
    }

    public function setMessageBody(string $messageBody): self
    {
        $this->messageBody = $messageBody;

        return $this;
    }

    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    public function setSenderName(string $senderName): self
    {
        $this->senderName = $senderName;

        return $this;
    }

    public function getIsDraft(): ?bool
    {
        return $this->isDraft;
    }

    public function setIsDraft(?bool $isDraft): self
    {
        $this->isDraft = $isDraft;

        return $this;
    }

    public function getRecipientEmail()
    {
        return $this->recipientEmail;
    }

    public function setRecipientEmail(?string $recipientEmail): self
    {
        $this->recipientEmail = $recipientEmail;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getSenderFrom(): ?string
    {
        return $this->senderFrom;
    }

    public function setSenderFrom(?string $senderFrom): self
    {
        $this->senderFrom = $senderFrom;

        return $this;
    }
}
