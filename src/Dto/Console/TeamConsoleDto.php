<?php

namespace App\Dto\Console;

use JMS\Serializer\Annotation as Serialization;

class TeamConsoleDto extends AbstractConsoleDto
{
    /**
     * @Serialization\Type("string")
     */
    public $name;

    /**
     * @Serialization\Type("array")
     */
    public $users;
}