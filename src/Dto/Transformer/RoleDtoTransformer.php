<?php

namespace App\Dto\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Console\RoleConsoleDto;
use App\Entity\Role;

class RoleDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param Role $entity
     * @return RoleConsoleDto
     */
    public function transformFromObject($entity): RoleConsoleDto
    {
        if (!$entity instanceof Role) {
            throw new UnexpectedTypeException('Expected type of Role but got ' . \get_class($entity));
        }

        $dto = new RoleConsoleDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();
        $dto->name = $entity->getName();

        return $dto;
    }
}