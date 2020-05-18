<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
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
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="user")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentari", mappedBy="user")
     */
    private $comentaris;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $cognom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $data_naixament;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $genere;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $codi_postal;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $nom_usuari;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $imatge;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ultim_login;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_registre;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $github;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $linkedin;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SocialMedia", mappedBy="usuari")
     */
    private $socialMedia;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->comentaris = new ArrayCollection();
        $this->socialMedia = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->nom_usuari;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

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
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

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
            $comentari->setUser($this);
        }

        return $this;
    }

    public function removeComentari(Comentari $comentari): self
    {
        if ($this->comentaris->contains($comentari)) {
            $this->comentaris->removeElement($comentari);
            // set the owning side to null (unless already changed)
            if ($comentari->getUser() === $this) {
                $comentari->setUser(null);
            }
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

    public function getCognom(): ?string
    {
        return $this->cognom;
    }

    public function setCognom(string $cognom): self
    {
        $this->cognom = $cognom;

        return $this;
    }

    public function getDataNaixament(): ?\DateTimeInterface
    {
        return $this->data_naixament;
    }

    public function setDataNaixament(?\DateTimeInterface $data_naixament): self
    {
        $this->data_naixament = $data_naixament;

        return $this;
    }

    public function getEdat(): ?int
    {
        if($this->data_naixament == null){
            return null;
        }

        $data_naixament = $this->data_naixament;
        $dataStr = $data_naixament->format('Y-m-d');
        list($any,$mes,$dia) = explode("-",$dataStr);
        $any_diferencia  = date("Y") - $any;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $any_diferencia--;
        return $any_diferencia;
    }

    public function getGenere(): ?string
    {
        return $this->genere;
    }

    public function setGenere(?string $genere): self
    {
        $this->genere = $genere;

        return $this;
    }

    public function getCodiPostal(): ?string
    {
        return $this->codi_postal;
    }

    public function setCodiPostal(?string $codi_postal): self
    {
        $this->codi_postal = $codi_postal;

        return $this;
    }

    public function getNomUsuari(): ?string
    {
        return $this->nom_usuari;
    }

    public function setNomUsuari(string $nom_usuari): self
    {
        $this->nom_usuari = $nom_usuari;

        return $this;
    }

    public function getImatge(): ?string
    {
        return $this->imatge;
    }

    public function setImatge(?string $imatge): self
    {
        $this->imatge = $imatge;

        return $this;
    }

    public function getUltimLogin(): ?\DateTimeInterface
    {
        return $this->ultim_login;
    }

    public function setUltimLogin(?\DateTimeInterface $ultim_login): self
    {
        $this->ultim_login = $ultim_login;

        return $this;
    }

    public function getDataRegistre(): ?\DateTimeInterface
    {
        return $this->data_registre;
    }

    public function setDataRegistre(\DateTimeInterface $data_registre): self
    {
        $this->data_registre = $data_registre;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): self
    {
        $this->github = $github;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * @return Collection|SocialMedia[]
     */
    public function getSocialMedia(): Collection
    {
        return $this->socialMedia;
    }

    public function addSocialMedium(SocialMedia $socialMedium): self
    {
        if (!$this->socialMedia->contains($socialMedium)) {
            $this->socialMedia[] = $socialMedium;
            $socialMedium->addUsuari($this);
        }

        return $this;
    }

    public function removeSocialMedium(SocialMedia $socialMedium): self
    {
        if ($this->socialMedia->contains($socialMedium)) {
            $this->socialMedia->removeElement($socialMedium);
            $socialMedium->removeUsuari($this);
        }

        return $this;
    }
}
