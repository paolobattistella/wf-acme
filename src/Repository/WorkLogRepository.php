<?php

namespace App\Repository;

use App\Entity\WorkLog;
use App\Repository\Contract\WorkLogRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;

class WorkLogRepository extends AbstractRepository implements WorkLogRepositoryContract
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, WorkLog::class);
    }
}
