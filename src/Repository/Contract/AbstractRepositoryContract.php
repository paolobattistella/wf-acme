<?php

namespace App\Repository\Contract;

interface AbstractRepositoryContract
{
    public function find(int $id);
    public function findOneWhere(array $criteria);
    public function findAll(): array;
    public function findAllWhere(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array;
    public function store(array $data);
    public function update(object $entity, array $data);
}
