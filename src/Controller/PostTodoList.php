<?php

namespace App\Controller;
use App\Entity\ToDoList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Security;
use App\Repository\UsersRepository;

#[AsController]
class PostTodoList extends AbstractController
{
    public function __construct(public Security $security, public UsersRepository $usersRepository)
    {
    }

    public function __invoke(ToDoList $data): ToDoList
    {
        $user = $this->security->getUser();
        $userUpdate = $this->usersRepository->find($user->getId());
        $data->setUsers($userUpdate);
        return $data;
    }
}