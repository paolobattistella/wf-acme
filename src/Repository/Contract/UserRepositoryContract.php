<?php

namespace App\Repository\Contract;

interface UserRepositoryContract extends AbstractRepositoryContract {
    public function findAllByRole(string $role);
    public function findOneByFullname(string $fullname);
}
