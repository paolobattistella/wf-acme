<?php

namespace App\Dto\Console;

use JMS\Serializer\Annotation as Serialization;

class ProjectConsoleDto extends AbstractConsoleDto
{
    /**
     * @Serialization\Type("string")
     */
    public $name;

    /**
     * @Serialization\Type("string")
     */
    public $description;

    /**
     * @Serialization\Type("string")
     */
    public $pm;
}