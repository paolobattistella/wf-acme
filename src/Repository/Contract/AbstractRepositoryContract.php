<?php

namespace App\Repository\Contract;

interface AbstractRepositoryContract
{
    public function find(int $id);
    public function findOneWhere(array $criteria);
    public function findAll();
    public function store(array $data);
    public function update(object $entity, array $data);
}
