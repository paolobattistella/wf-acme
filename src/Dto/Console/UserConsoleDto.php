<?php

namespace App\Dto\Console;

use JMS\Serializer\Annotation as Serialization;

class UserConsoleDto extends AbstractConsoleDto
{
    /**
     * @Serialization\Type("string")
     */
    public $firstname;

    /**
     * @Serialization\Type("string")
     */
    public $lastname;

    /**
     * @Serialization\Type("string")
     */
    public $team;

    /**
     * @Serialization\Type("string")
     */
    public $role;
}