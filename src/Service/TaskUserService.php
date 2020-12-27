<?php

namespace App\Service;

use App\Entity\TaskUser;
use App\Repository\Contract\ProjectRepositoryContract;
use App\Repository\Contract\TaskUserRepositoryContract;

class TaskUserService
{
    protected $taskUserRepository;
    protected $projectRepository;

    public function __construct(TaskUserRepositoryContract $taskUserRepository, ProjectRepositoryContract $projectRepository)
    {
        $this->taskUserRepository = $taskUserRepository;
        $this->projectRepository = $projectRepository;
    }

    public function getById(int $id): ?TaskUser
    {
        return $this->taskUserRepository->find($id);
    }

    public function getAllActiveTasksByUser(int $userId): ?array
    {
        $taskUsers = $this->taskUserRepository->findAllWhere(['user' => $userId, 'active' => true]);

        return array_map(
            function ($taskUser) {
                return $taskUser->getTask();
            },
            $taskUsers
        );
    }

    public function getAllActiveTasksByUserAndStatus(int $userId, string $status): ?array
    {
        $taskUsers = $this->taskUserRepository->findAllWhere(['user' => $userId, 'status' => $status, 'active' => true]);

        return array_map(
            function ($taskUser) {
                return $taskUser->getTask();
            },
            $taskUsers
        );
    }

    public function getAll(): ?array
    {
        return $this->taskUserRepository->findAll();
    }

    public function create(array $data): ?TaskUser
    {
        if (!empty($data['project'])) {
            $project = $this->projectRepository->findOneWhere(['name' => $data['project']]);
            $data['project'] = $project;
        }
        $data['status'] = 'created';

        return $this->taskUserRepository->store($data);
    }

    public function update(TaskUser $project, array $data): ?TaskUser
    {
        if (!empty($data['project'])) {
            $project = $this->projectRepository->findOneWhere(['name' => $data['project']]);
            $data['project'] = $project;
        }

        return $this->taskUserRepository->update($project, $data);
    }
}