<?php

namespace App\Entity;

use App\Repository\WorksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorksRepository::class)
 */
class Works
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;    

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $validate_date;    

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $estimate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $invoice;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start_datetime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finish_datetime;    

    /**
     * @ORM\ManyToOne(targetEntity=Building::class, inversedBy="works")
     * @ORM\JoinColumn(nullable=false)
     */
    private $building;

    /**
     * @ORM\ManyToOne(targetEntity=Sector::class, inversedBy="works")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sector;

    /**
     * @ORM\ManyToOne(targetEntity=Equipement::class, inversedBy="works")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipement;    

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="works_request")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_request;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="works_technicien")
     */
    private $user_technicien;

    /**
     * @ORM\ManyToOne(targetEntity=CompagnyService::class, inversedBy="works")
     */
    private $compagny_service;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="works")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Ville;      

    public function getId(): ?int
    {
        return $this->id;
    }    

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getValidateDate(): ?\DateTimeInterface
    {
        return $this->validate_date;
    }

    public function setValidateDate(?\DateTimeInterface $validate_date): self
    {
        $this->validate_date = $validate_date;

        return $this;
    } 
    
    public function getEstimate(): ?string
    {
        return $this->estimate;
    }

    public function setEstimate(?string $estimate): self
    {
        $this->estimate = $estimate;

        return $this;
    }

    public function getInvoice(): ?string
    {
        return $this->invoice;
    }

    public function setInvoice(?string $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getStartDatetime(): ?\DateTimeInterface
    {
        return $this->start_datetime;
    }

    public function setStartDatetime(?\DateTimeInterface $start_datetime): self
    {
        $this->start_datetime = $start_datetime;

        return $this;
    }

    public function getFinishDatetime(): ?\DateTimeInterface
    {
        return $this->finish_datetime;
    }

    public function setFinishDatetime(?\DateTimeInterface $finish_datetime): self
    {
        $this->finish_datetime = $finish_datetime;

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

    public function getSector(): ?Sector
    {
        return $this->sector;
    }

    public function setSector(?Sector $sector): self
    {
        $this->sector = $sector;

        return $this;
    }

    public function getEquipement(): ?Equipement
    {
        return $this->equipement;
    }

    public function setEquipement(?Equipement $equipement): self
    {
        $this->equipement = $equipement;

        return $this;
    }
    
    public function getUserRequest(): ?Users
    {
        return $this->user_request;
    }

    public function setUserRequest(?Users $user_request): self
    {
        $this->user_request = $user_request;

        return $this;
    }

    public function getUserTechnicien(): ?Users
    {
        return $this->user_technicien;
    }

    public function setUserTechnicien(?Users $user_technicien): self
    {
        $this->user_technicien = $user_technicien;

        return $this;
    }

    public function getCompagnyService(): ?CompagnyService
    {
        return $this->compagny_service;
    }

    public function setCompagnyService(?CompagnyService $compagny_service): self
    {
        $this->compagny_service = $compagny_service;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->Ville;
    }

    public function setVille(?Ville $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }    
   
}
