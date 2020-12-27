<?php

namespace App\Dto\Console;

use JMS\Serializer\Annotation as Serialization;

class TaskConsoleDto extends AbstractConsoleDto
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
    public $project;

    /**
     * @Serialization\Type("string")
     */
    public $status;

    /**
     * @Serialization\Type("DateTime<'d/m/Y'>")
     */
    public $deadline;
}