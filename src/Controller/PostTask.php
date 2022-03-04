<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Security;

#[AsController]
class PostTask extends AbstractController

{

    public function __construct(public Security $security, public UsersRepository $usersRepository)
    {
    }

    public function __invoke(Task $data): Task
    {
        $user = $this->security->getUser();
        $userUpdate = $this->usersRepository->find($user->getId());
        $data->setUsers($userUpdate);
        return $data;
    }
}