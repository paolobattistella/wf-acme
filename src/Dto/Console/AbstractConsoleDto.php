<?php

namespace App\Dto\Console;

use JMS\Serializer\Annotation as Serialization;

abstract class AbstractConsoleDto
{
    /**
     * @Serialization\Type("integer")
     * @Serialization\SerializedName("ID")
     */
    public $id;

    /**
     * @Serialization\Type("DateTime<'d/m/Y H:i:s'>")
     * @Serialization\SerializedName("created at")
     */
    public $createdAt;

    /**
     * @Serialization\Type("DateTime<'d/m/Y H:i:s'>")
     * @Serialization\SerializedName("modified at")
     */
    public $updatedAt;
}