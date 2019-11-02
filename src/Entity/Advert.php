<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Security;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvertRepository")
 */
class Advert
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
	private $title;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $content;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $updatedAt;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="advert")
	 */
	private $comments;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="adverts")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $author;

	/**
	 * Advert constructor.
	 *
	 */
	public function __construct()
	{
		$this->comments  = new ArrayCollection();
		$this->createdAt = new \DateTime();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(?string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getContent(): ?string
	{
		return $this->content;
	}

	public function setContent(?string $content): self
	{
		$this->content = $content;

		return $this;
	}

	public function getAuthor()
	{
		return $this->author;
	}

	public function setAuthor(User $author): self
	{
		$this->author = $author;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?\DateTimeInterface $createdAt): self
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getUpdatedAt(): ?\DateTimeInterface
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * @return Collection|Comment[]
	 */
	public function getComments(): Collection
	{
		return $this->comments;
	}

	public function addComment(Comment $comment): self
	{
		if (!$this->comments->contains($comment))
		{
			$this->comments[] = $comment;
			$comment->setAdvert($this);
		}

		return $this;
	}

	public function removeComment(Comment $comment): self
	{
		if ($this->comments->contains($comment))
		{
			$this->comments->removeElement($comment);
			// set the owning side to null (unless already changed)
			if ($comment->getAdvert() === $this)
			{
				$comment->setAdvert(null);
			}
		}

		return $this;
	}
}
