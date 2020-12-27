<?php

namespace App\Dto\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Console\TaskConsoleDto;
use App\Entity\Task;

class TaskDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param Task $entity
     * @return TaskConsoleDto
     */
    public function transformFromObject($entity): TaskConsoleDto
    {
        if (!$entity instanceof Task) {
            throw new UnexpectedTypeException('Expected type of Task but got ' . \get_class($entity));
        }

        $dto = new TaskConsoleDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();
        $dto->name = $entity->getName();
        $dto->description = $entity->getDescription();
        $dto->project = $entity->getProject()->getName();
        $dto->status = $entity->getStatus();
        $dto->deadline = $entity->getDeadline();

        return $dto;
    }
}