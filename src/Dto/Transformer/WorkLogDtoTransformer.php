<?php

namespace App\Dto\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Console\WorkLogConsoleDto;
use App\Entity\WorkLog;

class WorkLogDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param WorkLog $entity
     * @return WorkLogConsoleDto
     */
    public function transformFromObject($entity): WorkLogConsoleDto
    {
        if (!$entity instanceof WorkLog) {
            throw new UnexpectedTypeException('Expected type of WorkLog but got ' . \get_class($entity));
        }

        $dto = new WorkLogConsoleDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->user = $entity->getUser()->getFullname();
        $dto->io = $entity->getIo();

        return $dto;
    }
}