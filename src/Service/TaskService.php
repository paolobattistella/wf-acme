<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\Contract\ProjectRepositoryContract;
use App\Repository\Contract\TaskRepositoryContract;

class TaskService
{
    protected $taskRepository;
    protected $projectRepository;

    public function __construct(TaskRepositoryContract $taskRepository, ProjectRepositoryContract $projectRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
    }

    public function getAll(): ?array
    {
        return $this->taskRepository->findAll();
    }

    public function getById(int $id): ?Task
    {
        return $this->taskRepository->find($id);
    }

    public function create(array $data): ?Task
    {
        if (!empty($data['project'])) {
            $project = $this->projectRepository->findOneWhere(['name' => $data['project']]);
            $data['project'] = $project;
        }
        $data['status'] = 'created';

        return $this->taskRepository->store($data);
    }

    public function update(Task $project, array $data): ?Task
    {
        if (!empty($data['project'])) {
            $project = $this->projectRepository->findOneWhere(['name' => $data['project']]);
            $data['project'] = $project;
        }

        return $this->taskRepository->update($project, $data);
    }
}