<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\TaskUser;
use App\Entity\Team;
use App\Entity\User;
use App\Repository\Contract\ProjectRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

class ProjectRepository extends AbstractRepository implements ProjectRepositoryContract
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Project::class);
    }

    public function findTeams(int $projectId, bool $active = true): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select('tm')
            ->from(Team::class, 'tm')
            ->innerJoin(User::class, 'u', Join::WITH, 'tm.id = u.team')
            ->innerJoin(TaskUser::class, 'tu', Join::WITH, 'u.id = tu.user')
            ->innerJoin(Task::class, 'tk', Join::WITH, 'tu.task = tk.id')
            ->where('tk.project = :project AND tu.active = :active')
            ->setParameter('project', $projectId)
            ->setParameter('active', $active);

        return $queryBuilder->getQuery()->getResult();
    }
}
