<?php

namespace App\Repository;

use App\Entity\Team;
use App\Repository\Contract\TeamRepositoryContract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class TeamRepository extends AbstractRepository implements TeamRepositoryContract
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Team::class);
    }
}
