<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HomepageSectionsRepository")
 */
class HomepageSections
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
    private $titol;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitol;

    /**
     * @ORM\Column(type="text")
     */
    private $contingut;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $menulink;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitol(): ?string
    {
        return $this->titol;
    }

    public function setTitol(string $titol): self
    {
        $this->titol = $titol;

        return $this;
    }

    public function getSubtitol(): ?string
    {
        return $this->subtitol;
    }

    public function setSubtitol(?string $subtitol): self
    {
        $this->subtitol = $subtitol;

        return $this;
    }

    public function getContingut(): ?string
    {
        return $this->contingut;
    }

    public function setContingut(string $contingut): self
    {
        $this->contingut = $contingut;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getMenulink(): ?string
    {
        return $this->menulink;
    }

    public function setMenulink(string $menulink): self
    {
        $this->menulink = $menulink;

        return $this;
    }
}
