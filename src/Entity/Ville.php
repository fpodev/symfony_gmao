<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class Ville
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zip_code;      

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="ville", cascade="persist")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Users::class)
     * 
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=Building::class, mappedBy="ville", cascade="persist")
     */
    private $building;    

    public function __construct()    {
        
        $this->users = new ArrayCollection();
        $this->building = new ArrayCollection();        
    } 

    public function __toString():?string
    {
        return $this->name;
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }
    
    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setVille($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getVille() === $this) {
                $user->setVille(null);
            }
        }

        return $this;
    }

    public function getContact(): ?users
    {
        return $this->contact;
    }

    public function setContact(?users $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection|Building[]
     */
    public function getBuilding(): Collection
    {
        return $this->building;
    }

    public function addBuilding(Building $building): self
    {
        if (!$this->building->contains($building)) {
            $this->building[] = $building;
            $building->setVille($this);
        }

        return $this;
    }

    public function removeBuilding(Building $building): self
    {
        if ($this->building->removeElement($building)) {
            // set the owning side to null (unless already changed)
            if ($building->getVille() === $this) {
                $building->setVille(null);
            }
        }

        return $this;
    }
}
