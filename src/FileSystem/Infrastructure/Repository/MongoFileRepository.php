<?php

declare(strict_types=1);

namespace App\FileSystem\Infrastructure\Repository;

use App\FileSystem\Domain\Model\File;
use App\FileSystem\Domain\Model\FileRepositoryInterface;
use App\Shared\Infrastructure\Mongo\MongoFilter;
use MongoDB\GridFS\Bucket;

final class MongoFileRepository implements FileRepositoryInterface
{
    private Bucket $storage;

    public function __construct(Bucket $fileStorage)
    {
        $this->storage = $fileStorage;
    }

    public function save(File $file): void
    {
        if (preg_match('/^data:/', $file->content)) {
            $stream = fopen($file->content, 'w+');
        } else {
            $stream = fopen('data:' . $file->mimeType . ';base64,' . $file->content, 'w+');
        }

        $this->storage->uploadFromStream($file->filename, $stream, [
            'metadata' => [
                'reference' => $file->reference,
                'mime_type' => $file->mimeType,
            ]
        ]);

    }

    public function get(string $reference): ?File
    {
        $filter = (new MongoFilter())
            ->filter('metadata.reference', $reference)
        ;

        $data = $this->storage->findOne($filter->getFilters(), [
            'typeMap' => [
                'array' => 'array',
                'document' => 'array',
                'root' => 'array',
            ],
        ]);

        if (empty($data)) {
            return null;
        }

        $stream = $this->storage->openDownloadStream($data['_id']);
        $file = new File(
            $data['metadata']['reference'],
            $data['filename'],
            $data['metadata']['mime_type'],
            base64_encode(stream_get_contents($stream))
        );

        fclose($stream);

        return $file;
    }

    public function delete(string $reference): void
    {
        $filter = (new MongoFilter())
            ->filter('metadata.reference', $reference)
        ;

        $data = $this->storage->findOne($filter->getFilters(), [
            'typeMap' => [
                'array' => 'array',
                'document' => 'array',
                'root' => 'array',
            ],
        ]);

        $this->storage->delete($data['_id']);
    }
}