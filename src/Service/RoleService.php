<?php

namespace App\Service;

use App\Entity\Role;
use App\Repository\Contract\RoleRepositoryContract;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryContract $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll(): ?array
    {
        return $this->roleRepository->findAll();
    }

    public function getById(int $id): ?Role
    {
        return $this->roleRepository->find($id);
    }

    public function getAllNames(): ?array
    {
        $roles = $this->getAll();
        return array_map(
            function ($role) {
                return $role->getName();
            },
            $roles
        );
    }

}