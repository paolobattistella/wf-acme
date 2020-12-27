<?php

namespace App\Service;

use App\Entity\Project;
use App\Repository\Contract\ProjectRepositoryContract;
use App\Repository\Contract\UserRepositoryContract;

class ProjectService
{
    protected $projectRepository;
    protected $userRepository;

    public function __construct(ProjectRepositoryContract $projectRepository, UserRepositoryContract $userRepositoryContract)
    {
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepositoryContract;
    }

    public function getById(int $id): ?Project
    {
        return $this->projectRepository->find($id);
    }

    public function getAll(): ?array
    {
        return $this->projectRepository->findAll();
    }

    public function getAllNames(): ?array
    {
        $projects = $this->getAll();
        return array_map(
            function ($project) {
                return $project->getName();
            },
            $projects
        );
    }

    public function getAllCrossed(): ?array
    {
        $projects = $this->getAll();

        return array_filter(
            $projects,
            function ($project) {
                $teams = $this->getInvolvedTeams($project->getId());
                return count($teams) > 1;
            }
        );
    }

    public function getInvolvedTeams(int $projectId): ?array
    {
        return $this->projectRepository->findTeams($projectId, true);
    }

    public function create(array $data): ?Project
    {
        if (!empty($data['pm'])) {
            $pm = $this->userRepository->findOneByFullname($data['pm']);
            $data['pm'] = $pm;
        }

        return $this->projectRepository->store($data);
    }

    public function update(Project $project, array $data): ?Project
    {
        if (!empty($data['pm'])) {
            $pm = $this->userRepository->findOneByFullname($data['pm']);
            $data['pm'] = $pm;
        }

        return $this->projectRepository->update($project, $data);
    }
}