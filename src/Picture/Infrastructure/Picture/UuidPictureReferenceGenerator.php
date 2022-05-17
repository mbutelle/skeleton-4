<?php

namespace App\Picture\Infrastructure\Picture;

use App\Picture\Domain\Model\PictureReferenceGeneratorInterface;
use Ramsey\Uuid\Uuid;

final class UuidPictureReferenceGenerator implements PictureReferenceGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid6()->toString();
    }
}