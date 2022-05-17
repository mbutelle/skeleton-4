<?php

declare(strict_types=1);

namespace App\Picture\Infrastructure\Dto\Input;

use JMS\Serializer\Annotation as Serializer;

final class Picture
{
    /**
     * @Serializer\Type("string")
     */
    public string $file;

    /**
     * @Serializer\Type("string")
     */
    public string $author;

    /**
     * @Serializer\Type("string")
     */
    public ?string $description = null;
}