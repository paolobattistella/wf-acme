<?php

namespace App\Service;

use App\Entity\Team;
use App\Repository\Contract\TeamRepositoryContract;

class TeamService
{
    protected $teamRepository;

    public function __construct(TeamRepositoryContract $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function getAll(): ?array
    {
        return $this->teamRepository->findAll();
    }

    public function getById(int $id): ?Team
    {
        return $this->teamRepository->find($id);
    }

    public function getAllNames(): ?array
    {
        $teams = $this->getAll();
        return array_map(
            function ($team) {
                return $team->getName();
            },
            $teams
        );
    }
}