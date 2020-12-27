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

    public function findAllExpired(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('t')
            ->from(Task::class, 't')
            ->where('t.deadline < :deadline AND t.status != \'ended\'')
            ->setParameter('deadline', date('Y-m-d'));
        return $queryBuilder->getQuery()->getResult();
    }
}
