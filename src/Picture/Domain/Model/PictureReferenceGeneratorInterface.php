<?php

namespace App\Picture\Domain\Model;

interface PictureReferenceGeneratorInterface
{
    public function generate(): string;
}