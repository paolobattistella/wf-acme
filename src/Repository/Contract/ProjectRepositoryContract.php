<?php

namespace App\Repository\Contract;

interface ProjectRepositoryContract extends AbstractRepositoryContract
{
    public function findTeams(int $projectId, bool $active = true): ?array;
}
