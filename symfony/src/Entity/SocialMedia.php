<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocialMediaRepository")
 */
class SocialMedia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="socialMedia")
     */
    private $usuari;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    public function __construct()
    {
        $this->usuari = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getlogo(): ?string
    {
        return $this->logo;
    }

    public function setlogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsuari(): Collection
    {
        return $this->usuari;
    }

    public function addUsuari(User $usuari): self
    {
        if (!$this->usuari->contains($usuari)) {
            $this->usuari[] = $usuari;
        }

        return $this;
    }

    public function removeUsuari(User $usuari): self
    {
        if ($this->usuari->contains($usuari)) {
            $this->usuari->removeElement($usuari);
        }

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
}
