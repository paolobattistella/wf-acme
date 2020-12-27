<?php

namespace App\Dto\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Console\ProjectConsoleDto;
use App\Entity\Project;

class ProjectDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param Project $entity
     * @return ProjectConsoleDto
     */
    public function transformFromObject($entity): ProjectConsoleDto
    {
        if (!$entity instanceof Project) {
            throw new UnexpectedTypeException('Expected type of Project but got ' . \get_class($entity));
        }

        $dto = new ProjectConsoleDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
        $dto->pm = $entity->getPm()->getFullname();

        return $dto;
    }
}