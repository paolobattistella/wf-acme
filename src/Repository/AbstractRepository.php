<?php

namespace App\Repository;

use App\Repository\Contract\AbstractRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractRepository implements AbstractRepositoryContract
{
    protected $entityClass;
    protected $entityManager;
    protected $entityRepository;

    public function __construct(EntityManagerInterface $entityManager, string $entityClass)
    {
        $this->entityClass = $entityClass;
        $this->entityManager = $entityManager;
        $this->entityRepository = $this->entityManager->getRepository($this->entityClass);
    }

    public function find(int $id)
    {
        return $this->entityRepository->find($id);
    }

    public function findOneWhere(array $criteria)
    {
        return $this->entityRepository->findOneBy($criteria);
    }

    public function findAll(): array
    {
        return $this->entityRepository->findAll();
    }

    public function findAllWhere(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function store(array $data)
    {
        $entity = new $this->entityClass();
        foreach($data as $field => $value) {
            $entity->{'set'.ucfirst($field)}($value);
        }
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    public function update(object $entity, array $data)
    {
        foreach($data as $field => $value) {
            $entity->{'set'.ucfirst($field)}($value);
        }
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
