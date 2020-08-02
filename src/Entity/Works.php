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
     * @ORM\OneToOne(targetEntity=city::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity=building::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $building;

    /**
     * @ORM\OneToOne(targetEntity=sector::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $sector;

    /**
     * @ORM\OneToOne(targetEntity=equipement::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $epuipement;

    /**
     * @ORM\ManyToOne(targetEntity=users::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_applicant;

    /**
     * @ORM\ManyToOne(targetEntity=users::class)
     */
    private $technician;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $task;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $validate_date;

    /**
     * @ORM\ManyToOne(targetEntity=CompagnyService::class)
     */
    private $external_responce;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?city
    {
        return $this->city;
    }

    public function setCity(city $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBuilding(): ?building
    {
        return $this->building;
    }

    public function setBuilding(building $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getSector(): ?sector
    {
        return $this->sector;
    }

    public function setSector(sector $sector): self
    {
        $this->sector = $sector;

        return $this;
    }

    public function getEpuipement(): ?equipement
    {
        return $this->epuipement;
    }

    public function setEpuipement(equipement $epuipement): self
    {
        $this->epuipement = $epuipement;

        return $this;
    }

    public function getUserApplicant(): ?users
    {
        return $this->user_applicant;
    }

    public function setUserApplicant(?users $user_applicant): self
    {
        $this->user_applicant = $user_applicant;

        return $this;
    }

    public function getTechnician(): ?users
    {
        return $this->technician;
    }

    public function setTechnician(?users $technician): self
    {
        $this->technician = $technician;

        return $this;
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

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): self
    {
        $this->task = $task;

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

    public function getExternalResponce(): ?CompagnyService
    {
        return $this->external_responce;
    }

    public function setExternalResponce(?CompagnyService $external_responce): self
    {
        $this->external_responce = $external_responce;

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
}
