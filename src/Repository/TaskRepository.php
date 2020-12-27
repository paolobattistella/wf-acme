<?php

namespace App\Repository;

use App\Entity\Task;
use App\Repository\Contract\TaskRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;

class TaskRepository extends AbstractRepository implements TaskRepositoryContract
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Task::class);
    }
}
