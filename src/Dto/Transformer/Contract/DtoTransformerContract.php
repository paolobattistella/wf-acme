<?php

declare(strict_types=1);

namespace App\Dto\Transformer\Contract;

interface DtoTransformerContract
{
    public function transformFromObject($object);
    public function transformFromObjects(iterable $objects): iterable;
}
