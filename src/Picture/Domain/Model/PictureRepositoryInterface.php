<?php

namespace App\Picture\Domain\Model;

interface PictureRepositoryInterface
{
    public function get(string $reference): ?Picture;
    public function search(array $criteria): iterable;
    public function save(Picture $picture): void;
}