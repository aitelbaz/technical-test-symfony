<?php

namespace App\Entity;

use App\Controller\PostTodoList;
use App\Repository\ToDoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: ['post'=> [
        'method' => 'POST',
        'controller' => PostTodoList::class,
    ],
        'get',
    ],
    itemOperations: [
        'get',
        'delete' => [
            'access_control' => 'object.getUsers().getId() == user.getId()',
            'access_control_message' => 'Seul le propriétaire du TodoList peut la supprimer'
        ]
    ],
)
]
#[ORM\Entity(repositoryClass: ToDoListRepository::class)]
class ToDoList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]

    private $title;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'toDoLists')]
    #[ORM\JoinColumn(nullable: false)]

    private $users;

    #[ORM\OneToMany(mappedBy: 'listToDo', targetEntity: Task::class)]
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
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
            $this->tasks[] = $task;
            $task->setListToDo($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getListToDo() === $this) {
                $task->setListToDo(null);
            }
        }

        return $this;
    }
}
