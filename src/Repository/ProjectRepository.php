<?php

namespace App\Repository;

use App\Entity\Project;
use App\Repository\Contract\ProjectRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;

class ProjectRepository extends AbstractRepository implements ProjectRepositoryContract
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Project::class);
    }
}
