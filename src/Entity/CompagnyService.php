<?php

namespace App\Entity;

use App\Repository\CompagnyServiceRepository;
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
}
