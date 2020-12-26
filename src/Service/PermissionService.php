<?php

namespace App\Service;

use App\Entity\Permission;
use App\Repository\Contract\PermissionRepositoryContract;

class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryContract $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAll(): ?array
    {
        return $this->permissionRepository->findAll();
    }

    public function getById(int $id): ?Permission
    {
        return $this->permissionRepository->find($id);
    }
}