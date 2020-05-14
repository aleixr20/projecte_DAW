<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(type="datetime")
     */
    private $data_publicacio;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $data_actualitzacio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $meta_tag;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $meta_description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    // /**
    //  * @ORM\ManyToOne(targetEntity="App\Entity\Tema", inversedBy="articles")
    //  * @ORM\JoinColumn(nullable=true)
    //  */
    // private $tema;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentari", mappedBy="article")
     */
    private $comentaris;

    /**
     * @ORM\Column(type="string", length=99999)
     */
    private $contingut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Categoria;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    public function __construct()
    {
        $this->comentaris = new ArrayCollection();
    }

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

    public function setSubtitol(string $subtitol): self
    {
        $this->subtitol = $subtitol;

        return $this;
    }

    public function getDataPublicacio(): ?\DateTimeInterface
    {
        return $this->data_publicacio;
    }

    public function setDataPublicacio(\DateTimeInterface $data_publicacio): self
    {
        $this->data_publicacio = $data_publicacio;

        return $this;
    }

    public function getDataActualitzacio(): ?\DateTimeInterface
    {
        return $this->data_actualitzacio;
    }

    public function setDataActualitzacio(?\DateTimeInterface $data_actualitzacio): self
    {
        $this->data_actualitzacio = $data_actualitzacio;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getMetaTag(): ?string
    {
        return $this->meta_tag;
    }

    public function setMetaTag(?string $meta_tag): self
    {
        $this->meta_tag = $meta_tag;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(?string $meta_description): self
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Comentari[]
     */
    public function getComentaris(): Collection
    {
        return $this->comentaris;
    }

    public function addComentari(Comentari $comentari): self
    {
        if (!$this->comentaris->contains($comentari)) {
            $this->comentaris[] = $comentari;
            $comentari->setArticle($this);
        }

        return $this;
    }

    public function removeComentari(Comentari $comentari): self
    {
        if ($this->comentaris->contains($comentari)) {
            $this->comentaris->removeElement($comentari);
            // set the owning side to null (unless already changed)
            if ($comentari->getArticle() === $this) {
                $comentari->setArticle(null);
            }
        }

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

    public function getCategoria(): ?Categoria
    {
        return $this->Categoria;
    }

    public function setCategoria(?Categoria $Categoria): self
    {
        $this->Categoria = $Categoria;

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
}
