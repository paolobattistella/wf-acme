<?php

namespace App\Dto\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Console\TaskUserConsoleDto;
use App\Entity\TaskUser;

class TaskUserDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param TaskUser $entity
     * @return TaskUserConsoleDto
     */
    public function transformFromObject($entity): TaskUserConsoleDto
    {
        if (!$entity instanceof TaskUser) {
            throw new UnexpectedTypeException('Expected type of TaskUser but got ' . \get_class($entity));
        }

        $dto = new TaskUserConsoleDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();
        $dto->task = $entity->getTask()->getName();
        $dto->user = $entity->getUser()->getFullname();
        $dto->active = $entity->getActive();
        $dto->status = $entity->getStatus();

        return $dto;
    }
}