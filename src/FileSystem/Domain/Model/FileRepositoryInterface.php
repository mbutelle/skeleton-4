<?php

namespace App\FileSystem\Domain\Model;

interface FileRepositoryInterface
{
    public function save(File $file): void;
    public function get(string $reference): ?File;
    public function delete(string $reference): void;
}