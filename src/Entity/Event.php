<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/* We could add #[Groups(['getEvents'])] before id, title and description to include them in a serialization. 
Then, add $serializer->serialize($event, 'json', ['groups' => ['getEvents']]); in the controller. */
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $organizer = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: ContactInvitation::class, orphanRemoval: true)]
    private Collection $contactInvitations;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: EmployeeInvitation::class, orphanRemoval: true)]
    private Collection $employeeInvitations;

    public function __construct()
    {
        $this->contactInvitations = new ArrayCollection();
        $this->employeeInvitations = new ArrayCollection();
    }

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getOrganizer(): ?User
    {
        return $this->organizer;
    }

    public function setOrganizer(?User $organizer): self
    {
        $this->organizer = $organizer;

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
            $contactInvitation->setEvent($this);
        }

        return $this;
    }

    public function removeContactInvitation(ContactInvitation $contactInvitation): self
    {
        if ($this->contactInvitations->removeElement($contactInvitation)) {
            // set the owning side to null (unless already changed)
            if ($contactInvitation->getEvent() === $this) {
                $contactInvitation->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmployeeInvitation>
     */
    public function getEmployeeInvitations(): Collection
    {
        return $this->employeeInvitations;
    }

    public function addEmployeeInvitation(EmployeeInvitation $employeeInvitation): self
    {
        if (!$this->employeeInvitations->contains($employeeInvitation)) {
            $this->employeeInvitations->add($employeeInvitation);
            $employeeInvitation->setEvent($this);
        }

        return $this;
    }

    public function removeEmployeeInvitation(EmployeeInvitation $employeeInvitation): self
    {
        if ($this->employeeInvitations->removeElement($employeeInvitation)) {
            // set the owning side to null (unless already changed)
            if ($employeeInvitation->getEvent() === $this) {
                $employeeInvitation->setEvent(null);
            }
        }

        return $this;
    }
}
