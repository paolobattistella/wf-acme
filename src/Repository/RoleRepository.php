<?php

namespace App\Repository;

use App\Entity\Role;
use App\Repository\Contract\RoleRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;

class RoleRepository extends AbstractRepository implements RoleRepositoryContract
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Role::class);
    }
}
