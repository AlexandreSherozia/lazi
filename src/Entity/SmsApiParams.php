<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmsApiParamsRepository")
 */
class SmsApiParams
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire !")
     */
    private $applicationKey;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire !")
     */
    private $consumerKey;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire !")
     */
    private $applicationSecret;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire !")
     */
    private $endPoint;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $providerName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApplicationKey(): ?string
    {
        return $this->applicationKey;
    }

    public function setApplicationKey(?string $applicationKey): self
    {
        $this->applicationKey = $applicationKey;

        return $this;
    }

    public function getConsumerKey(): ?string
    {
        return $this->consumerKey;
    }

    public function setConsumerKey(?string $consumerKey): self
    {
        $this->consumerKey = $consumerKey;

        return $this;
    }

    public function getApplicationSecret(): ?string
    {
        return $this->applicationSecret;
    }

    public function setApplicationSecret(?string $applicationSecret): self
    {
        $this->applicationSecret = $applicationSecret;

        return $this;
    }

    public function getEndPoint(): ?string
    {
        return $this->endPoint;
    }

    public function setEndPoint(?string $endPoint): self
    {
        $this->endPoint = $endPoint;

        return $this;
    }

    public function getProviderName(): ?string
    {
        return $this->providerName;
    }

    public function setProviderName(?string $providerName): self
    {
        $this->providerName = $providerName;

        return $this;
    }
}
