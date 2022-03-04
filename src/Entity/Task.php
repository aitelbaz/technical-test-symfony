<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PostTask;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource(
    collectionOperations: ['post'=> [
        'method' => 'POST',
        'controller' => PostTask::class,
    ],
        'get',
    ],
    itemOperations: [
        'get',
        'put' => [
            'access_control' => 'object.getUsers().getId() == user.getId() or object.getListToDo().getUsers().getId() == user.getId()',
            'access_control_message' => 'Seul le propriétaire du task ou todolist peut la supprimer'
        ],
        'delete' => [
            'access_control' => 'object.getUsers().getId() == user.getId() or object.getListToDo().getUsers().getId() == user.getId()',
            'access_control_message' => 'Seul le propriétaire du task ou todolist peut la supprimer'
        ]
    ],
    )
]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'listToDo')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: ToDoList::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private $listToDo;

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

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getListToDo(): ?ToDoList
    {
        return $this->listToDo;
    }

    public function setListToDo(?ToDoList $listToDo): self
    {
        $this->listToDo = $listToDo;

        return $this;
    }
}
