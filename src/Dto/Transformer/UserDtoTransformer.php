<?php

namespace App\Dto\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Console\UserConsoleDto;
use App\Entity\User;

class UserDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param User $entity
     * @return UserConsoleDto
     */
    public function transformFromObject($entity): UserConsoleDto
    {
        if (!$entity instanceof User) {
            throw new UnexpectedTypeException('Expected type of User but got ' . \get_class($entity));
        }

        $dto = new UserConsoleDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();
        $dto->firstname = $entity->getFirstname();
        $dto->lastname = $entity->getLastname();
        $dto->team = $entity->getTeam() ? $entity->getTeam()->getName() : '';
        $dto->role = $entity->getRole()->getName() ?? '';

        return $dto;
    }
}