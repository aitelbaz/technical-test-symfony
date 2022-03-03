<?php

namespace App\Entity;

use App\Repository\ToDoListRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: ToDoListRepository::class)]
class ToDoList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("toDoList:read")]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("toDoList:write")]

    private $title;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'toDoLists')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("toDoList:write")]

    private $Users;

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
        return $this->Users;
    }

    public function setUsers(?Users $Users): self
    {
        $this->Users = $Users;

        return $this;
    }
}
