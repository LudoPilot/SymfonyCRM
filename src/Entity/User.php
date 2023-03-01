<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Task::class, orphanRemoval: true)]
    private Collection $tasks;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HostCompany $company = null;

    #[ORM\OneToMany(mappedBy: 'organizer', targetEntity: Event::class, orphanRemoval: true)]
    private Collection $events;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: ContactInvitation::class, orphanRemoval: true)]
    private Collection $contactInvitations;

    #[ORM\OneToMany(mappedBy: 'organizer', targetEntity: EmployeeInvitation::class, orphanRemoval: true)]
    private Collection $employeeInvitations;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->contactInvitations = new ArrayCollection();
        $this->employeeInvitations = new ArrayCollection();
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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setOwner($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getOwner() === $this) {
                $task->setOwner(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?HostCompany
    {
        return $this->company;
    }

    public function setCompany(?HostCompany $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setOrganizer($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getOrganizer() === $this) {
                $event->setOrganizer(null);
            }
        }

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
            $contactInvitation->setSender($this);
        }

        return $this;
    }

    public function removeContactInvitation(ContactInvitation $contactInvitation): self
    {
        if ($this->contactInvitations->removeElement($contactInvitation)) {
            // set the owning side to null (unless already changed)
            if ($contactInvitation->getSender() === $this) {
                $contactInvitation->setSender(null);
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
            $employeeInvitation->setOrganizer($this);
        }

        return $this;
    }

    public function removeEmployeeInvitation(EmployeeInvitation $employeeInvitation): self
    {
        if ($this->employeeInvitations->removeElement($employeeInvitation)) {
            // set the owning side to null (unless already changed)
            if ($employeeInvitation->getOrganizer() === $this) {
                $employeeInvitation->setOrganizer(null);
            }
        }

        return $this;
    }
}
