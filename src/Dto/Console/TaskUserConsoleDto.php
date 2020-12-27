<?php

namespace App\Dto\Console;

use JMS\Serializer\Annotation as Serialization;

class TaskUserConsoleDto extends AbstractConsoleDto
{
    /**
     * @Serialization\Type("string")
     */
    public $task;

    /**
     * @Serialization\Type("string")
     */
    public $user;

    /**
     * @Serialization\Type("boolean")
     */
    public $active;
}