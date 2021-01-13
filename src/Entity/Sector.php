<?php

namespace App\Entity;

use App\Repository\SectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectorRepository::class)
 */
class Sector
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Building::class, inversedBy="sectors", cascade={"persist"})
     */
    private $building;

    /**
     * @ORM\OneToMany(targetEntity=Equipement::class, mappedBy="sector", cascade={"persist"})
     */
    private $equipements;

    /**
     * @ORM\OneToMany(targetEntity=Works::class, mappedBy="sector")
     */
    private $works;
    
    public function __toString():?string
    {
        return $this->name;
    }
    
    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->works = new ArrayCollection();
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

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    /**
     * @return Collection|Equipement[]
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
            $equipement->setSector($this);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getSector() === $this) {
                $equipement->setSector(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Works[]
     */
    public function getWorks(): Collection
    {
        return $this->works;
    }

    public function addWork(Works $work): self
    {
        if (!$this->works->contains($work)) {
            $this->works[] = $work;
            $work->setSector($this);
        }

        return $this;
    }

    public function removeWork(Works $work): self
    {
        if ($this->works->removeElement($work)) {
            // set the owning side to null (unless already changed)
            if ($work->getSector() === $this) {
                $work->setSector(null);
            }
        }

        return $this;
    }
   
}
