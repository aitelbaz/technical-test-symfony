<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ApiResource(
    collectionOperations: ['post'],
    itemOperations: ['get'],
)]
class Users implements UserInterface, JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    #[Groups("users:read")]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    
    #[Groups("users:write")]
    #[SerializedName("password")]
     
    private $plainPassword;

    #[ORM\OneToMany(mappedBy: 'Users', targetEntity: ToDoList::class)]
    private $toDoLists;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Task::class)]
    private $listToDo;

    public function __construct()
    {
        $this->toDoLists = new ArrayCollection();
        $this->listToDo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
    public static function createFromPayload($identifiant, array $payload): Users
    {
        $user = new Users();
        $user->setId($identifiant);
        return $user;
    }

    /**
     * @return Collection<int, ToDoList>
     */
    public function getToDoLists(): Collection
    {
        return $this->toDoLists;
    }

    public function addToDoList(ToDoList $toDoList): self
    {
        if (!$this->toDoLists->contains($toDoList)) {
            $this->toDoLists[] = $toDoList;
            $toDoList->setUsers($this);
        }

        return $this;
    }

    public function removeToDoList(ToDoList $toDoList): self
    {
        if ($this->toDoLists->removeElement($toDoList)) {
            // set the owning side to null (unless already changed)
            if ($toDoList->getUsers() === $this) {
                $toDoList->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getListToDo(): Collection
    {
        return $this->listToDo;
    }

    public function addListToDo(Task $listToDo): self
    {
        if (!$this->listToDo->contains($listToDo)) {
            $this->listToDo[] = $listToDo;
            $listToDo->setUser($this);
        }

        return $this;
    }

    public function removeListToDo(Task $listToDo): self
    {
        if ($this->listToDo->removeElement($listToDo)) {
            // set the owning side to null (unless already changed)
            if ($listToDo->getUser() === $this) {
                $listToDo->setUser(null);
            }
        }

        return $this;
    }
}
