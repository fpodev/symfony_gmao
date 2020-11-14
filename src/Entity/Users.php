<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;    

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $activate_date;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="users")     * )
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Works::class, mappedBy="user_request")
     */
    private $works_request;

    /**
     * @ORM\OneToMany(targetEntity=Works::class, mappedBy="user_technicien")
     */
    private $works_technicien;
    
    public function __construct()
    {
        $this->works_request = new ArrayCollection();
        $this->works_technicien = new ArrayCollection();
        
    }    
    
    public function __toString()
    {
        if(is_null($this->email)) {
            return 'NULL';
        }    
        return $this->email;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->name;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
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

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->create_date;
    }

    public function setCreateDate(\DateTimeInterface $create_date): self
    {
        $this->create_date = $create_date;

        return $this;
    }

    public function getActivateDate(): ?\DateTimeInterface
    {
        return $this->activate_date;
    }

    public function setActivateDate(?\DateTimeInterface $activate_date): self
    {
        $this->activate_date = $activate_date;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Works[]
     */
    public function getWorksRequest(): Collection
    {
        return $this->works_request;
    }

    public function addWorksRequest(Works $worksRequest): self
    {
        if (!$this->works_request->contains($worksRequest)) {
            $this->works_request[] = $worksRequest;
            $worksRequest->setUserRequest($this);
        }

        return $this;
    }

    public function removeWorksRequest(Works $worksRequest): self
    {
        if ($this->works_request->removeElement($worksRequest)) {
            // set the owning side to null (unless already changed)
            if ($worksRequest->getUserRequest() === $this) {
                $worksRequest->setUserRequest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Works[]
     */
    public function getWorksTechnicien(): Collection
    {
        return $this->works_technicien;
    }

    public function addWorksTechnicien(Works $worksTechnicien): self
    {
        if (!$this->works_technicien->contains($worksTechnicien)) {
            $this->works_technicien[] = $worksTechnicien;
            $worksTechnicien->setUserTechnicien($this);
        }

        return $this;
    }

    public function removeWorksTechnicien(Works $worksTechnicien): self
    {
        if ($this->works_technicien->removeElement($worksTechnicien)) {
            // set the owning side to null (unless already changed)
            if ($worksTechnicien->getUserTechnicien() === $this) {
                $worksTechnicien->setUserTechnicien(null);
            }
        }

        return $this;
    }    

}
