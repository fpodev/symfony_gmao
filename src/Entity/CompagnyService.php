<?php

namespace App\Entity;

use App\Repository\CompagnyServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompagnyServiceRepository::class)
 */
class CompagnyService
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
    private $contact_mail;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $phone_contact;

    /**
     * @ORM\OneToMany(targetEntity=Works::class, mappedBy="compagny_service")
     */
    private $works;

    public function __construct()
    {
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

    public function getContactMail(): ?string
    {
        return $this->contact_mail;
    }

    public function setContactMail(string $contact_mail): self
    {
        $this->contact_mail = $contact_mail;

        return $this;
    }

    public function getPhoneContact(): ?string
    {
        return $this->phone_contact;
    }

    public function setPhoneContact(string $phone_contact): self
    {
        $this->phone_contact = $phone_contact;

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
            $work->setCompagnyService($this);
        }

        return $this;
    }

    public function removeWork(Works $work): self
    {
        if ($this->works->removeElement($work)) {
            // set the owning side to null (unless already changed)
            if ($work->getCompagnyService() === $this) {
                $work->setCompagnyService(null);
            }
        }

        return $this;
    }
    
}
