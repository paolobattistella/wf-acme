<?php

namespace App\Repository;

use App\Entity\Permission;
use App\Repository\Contract\PermissionRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;

class PermissionRepository extends AbstractRepository implements PermissionRepositoryContract
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Permission::class);
    }
}
