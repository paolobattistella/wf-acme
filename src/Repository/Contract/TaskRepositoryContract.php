<?php

namespace App\Repository\Contract;

interface TaskRepositoryContract extends AbstractRepositoryContract {
    public function findAllExpired(): ?array;
}
