<?php

namespace App\Dto\Console;

use JMS\Serializer\Annotation as Serialization;

class RoleConsoleDto extends AbstractConsoleDto
{
    /**
     * @Serialization\Type("string")
     */
    public $name;
}