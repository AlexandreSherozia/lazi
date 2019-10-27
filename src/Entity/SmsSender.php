<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmsSenderRepository")
 */
class SmsSender
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
    private $senderFrom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Entrez au moins un numéro en format international(+336... ou 00336...)")
     */
    private $recipientTo;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(message="Entrez un texte")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDraft;

    /**
     * SmsSender constructor.
     */
    public function __construct()
    {
        $this->datetime = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRecipientTo(): ?string
    {
        return $this->recipientTo;
    }

    public function setRecipientTo(?string $recipientTo): self
    {
        $this->recipientTo = $recipientTo;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

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

    public function getIsDraft(): ?bool
    {
        return $this->isDraft;
    }

    public function setIsDraft(?bool $isDraft): self
    {
        $this->isDraft = $isDraft;

        return $this;
    }
}
