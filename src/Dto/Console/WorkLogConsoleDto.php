<?php

namespace App\Dto\Console;

use JMS\Serializer\Annotation as Serialization;

class WorkLogConsoleDto extends AbstractConsoleDto
{
    /**
     * @Serialization\Type("string")
     */
    public $user;

    /**
     * @Serialization\Type("string")
     */
    public $io;
}