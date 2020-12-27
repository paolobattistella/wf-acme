<?php

namespace App\Repository;

use App\Entity\TaskUser;
use App\Repository\Contract\TaskUserRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;

class TaskUserRepository extends AbstractRepository implements TaskUserRepositoryContract
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, TaskUser::class);
    }
}
