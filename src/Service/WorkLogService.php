<?php

namespace App\Service;

use App\Entity\WorkLog;
use App\Repository\Contract\UserRepositoryContract;
use App\Repository\Contract\WorkLogRepositoryContract;

class WorkLogService
{
    protected $workLogRepository;
    protected $userRepository;

    public function __construct(WorkLogRepositoryContract $workLogRepository, UserRepositoryContract $userRepository)
    {
        $this->workLogRepository = $workLogRepository;
        $this->userRepository = $userRepository;
    }

    public function getAll(): ?array
    {
        return $this->workLogRepository->findAll();
    }

    public function getById(int $id): ?WorkLog
    {
        return $this->workLogRepository->find($id);
    }

    public function logIn(int $userId): ?WorkLog
    {
        $user = $this->userRepository->find($userId);

        $data = [
            'user' => $user,
            'io' => 'in'
        ];

        return $this->workLogRepository->store($data);
    }

    public function logOut(int $userId): ?WorkLog
    {
        $user = $this->userRepository->find($userId);

        $data = [
            'user' => $user,
            'io' => 'out'
        ];

        return $this->workLogRepository->store($data);
    }
}