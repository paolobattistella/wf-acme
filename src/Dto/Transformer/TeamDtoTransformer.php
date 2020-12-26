<?php

namespace App\Dto\Transformer;

use App\Dto\Exception\UnexpectedTypeException;
use App\Dto\Console\TeamConsoleDto;
use App\Entity\Team;

class TeamDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param Team $entity
     * @return TeamConsoleDto
     */
    public function transformFromObject($entity): TeamConsoleDto
    {
        if (!$entity instanceof Team) {
            throw new UnexpectedTypeException('Expected type of Team but got ' . \get_class($entity));
        }

        $dto = new TeamConsoleDto();
        $dto->id = $entity->getId();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();
        $dto->name = $entity->getName();

        if ($entity->getUsers()) {
            foreach($entity->getUsers() as $user) {
                $dto->users[] = ['id' => $user->getId(), 'fullname' => $user->getFullname()];
            }
        }

        return $dto;
    }
}