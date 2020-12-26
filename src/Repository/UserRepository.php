<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\Contract\UserRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, User::class);
    }

    public function findAllByRole(string $role): ?array
    {
        return array_filter(
            $this->entityRepository->findAll(),
            function ($user) use ($role) {
                return $user->getRole()->getName() === $role;
            }
        );
    }

    public function findOneByFullname(string $fullname): ?User
    {
        $users = array_filter(
            $this->entityRepository->findAll(),
            function ($user) use ($fullname) {
                return $user->getFullname() === $fullname;
            }
        );

        return reset($users);
    }
}
