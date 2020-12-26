<?php

namespace App\Dto\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Console\PermissionConsoleDto;
use App\Entity\Permission;

class PermissionDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param Permission $entity
     * @return PermissionConsoleDto
     */
    public function transformFromObject($entity): PermissionConsoleDto
    {
        if (!$entity instanceof Permission) {
            throw new UnexpectedTypeException('Expected type of Permission but got ' . \get_class($entity));
        }

        $dto = new PermissionConsoleDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();
        $dto->name = $entity->getName();

        return $dto;
    }
}