<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\Contract\UserRepositoryContract;
use App\Repository\Contract\PermissionRepositoryContract;
use App\Repository\Contract\RoleRepositoryContract;
use App\Repository\Contract\TeamRepositoryContract;

class UserService
{
    protected $userRepository;
    protected $roleRepository;
    protected $permissionRepository;
    protected $teamRepository;

    public function __construct(UserRepositoryContract $userRepository, RoleRepositoryContract $roleRepository, PermissionRepositoryContract $permissionRepository, TeamRepositoryContract $teamRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->teamRepository = $teamRepository;
    }

    public function getById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function getAll(): ?array
    {
        return $this->userRepository->findAll();
    }

    public function getAllByRole(string $role): ?array
    {
        return $this->userRepository->findAllByRole($role);
    }

    public function getAllPmNames(): ?array
    {
        $users = $this->getAllByRole('PM');
        return array_map(
            function ($user) {
                return $user->getFullname();
            },
            $users
        );
    }

    public function getAllDevNames(): ?array
    {
        $users = $this->getAllByRole('DEV');
        return array_map(
            function ($user) {
                return $user->getFullname();
            },
            $users
        );
    }

    public function isAllowedTo(int $id, string $requiredPermission): bool
    {
        $user = $this->userRepository->find($id);

        if ($user !== null && $user->getRole() !== null && $permissions = $user->getRole()->getPermissions()) {
            foreach($permissions as $grantedPermission) {
                if ($grantedPermission->getName() === $requiredPermission) {
                    return true;
                }
            }
        }

        return false;
    }

    public function create(array $data): ?User
    {
        if (!empty($data['role'])) {
            $role = $this->roleRepository->findOneWhere(['name' => $data['role']]);
            $data['role'] = $role;
        }

        return $this->userRepository->store($data);
    }

    public function update(User $user, array $data): ?User
    {
        if (!empty($data['role'])) {
            $role = $this->roleRepository->findOneWhere(['name' => $data['role']]);
            $data['role'] = $role;
        }
        if (!empty($data['team'])) {
            $team = $this->teamRepository->findOneWhere(['name' => $data['team']]);
            $data['team'] = $team;
        }

        return $this->userRepository->update($user, $data);
    }
}