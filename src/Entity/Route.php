<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RouteRepository")
 */
class Route
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     *
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $routeName;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $route;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $routeRequirements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="route")
     */
    private $adverts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Route", inversedBy="routes")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Route", mappedBy="parent")
     */
    private $routes;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $bootstrapIcon;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAdminMenu;

    public function __construct()
    {
        $this->adverts = new ArrayCollection();
        $this->routes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    public function setRouteName(string $routeName): self
    {
        $this->routeName = $routeName;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getRouteRequirements(): ?string
    {
        return $this->routeRequirements;
    }

    public function setRouteRequirements(?string $routeRequirements): self
    {
        $this->routeRequirements = $routeRequirements;

        return $this;
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
            $advert->setRoute($this);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->contains($advert)) {
            $this->adverts->removeElement($advert);
            // set the owning side to null (unless already changed)
            if ($advert->getRoute() === $this) {
                $advert->setRoute(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    public function addRoute(self $route): self
    {
        if (!$this->routes->contains($route)) {
            $this->routes[] = $route;
            $route->setParent($this);
        }

        return $this;
    }

    public function removeRoute(self $route): self
    {
        if ($this->routes->contains($route)) {
            $this->routes->removeElement($route);
            // set the owning side to null (unless already changed)
            if ($route->getParent() === $this) {
                $route->setParent(null);
            }
        }

        return $this;
    }

    public function getBootstrapIcon(): ?string
    {
        return $this->bootstrapIcon;
    }

    public function setBootstrapIcon(?string $bootstrapIcon): self
    {
        $this->bootstrapIcon = $bootstrapIcon;

        return $this;
    }

    public function getIsAdminMenu(): ?bool
    {
        return $this->isAdminMenu;
    }

    public function setIsAdminMenu(?bool $isAdminMenu): self
    {
        $this->isAdminMenu = $isAdminMenu;

        return $this;
    }

}
