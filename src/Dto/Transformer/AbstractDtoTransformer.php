<?php

namespace App\Dto\Transformer;

use App\Dto\Transformer\Contract\DtoTransformerContract;

abstract class AbstractDtoTransformer implements DtoTransformerContract
{
    public function transformFromObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->transformFromObject($object);
        }

        return $dto;
    }
}