<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

	#[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

	#[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    #[ORM\Column(length: 50)]
    private ?string $lastName = null;

	#[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 50)]
    #[ORM\Column(length: 50)]
    private ?string $email = null;

	#[Assert\Length(max: 20)]
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?ExternalCompany $company = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HostCompany $owner = null;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: ContactInvitation::class, orphanRemoval: true)]
    private Collection $contactInvitations;

    public function __construct()
    {
        $this->contactInvitations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCompany(): ?ExternalCompany
    {
        return $this->company;
    }

    public function setCompany(?ExternalCompany $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getOwner(): ?HostCompany
    {
        return $this->owner;
    }

    public function setOwner(?HostCompany $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, ContactInvitation>
     */
    public function getContactInvitations(): Collection
    {
        return $this->contactInvitations;
    }

    public function addContactInvitation(ContactInvitation $contactInvitation): self
    {
        if (!$this->contactInvitations->contains($contactInvitation)) {
            $this->contactInvitations->add($contactInvitation);
            $contactInvitation->setContact($this);
        }

        return $this;
    }

    public function removeContactInvitation(ContactInvitation $contactInvitation): self
    {
        if ($this->contactInvitations->removeElement($contactInvitation)) {
            // set the owning side to null (unless already changed)
            if ($contactInvitation->getContact() === $this) {
                $contactInvitation->setContact(null);
            }
        }

        return $this;
    }
}
