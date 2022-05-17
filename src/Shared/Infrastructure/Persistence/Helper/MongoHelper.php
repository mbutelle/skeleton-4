<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Helper;

trait MongoHelper
{
    public function modelToUpdateDocument(object $object): array
    {
        $updateDocument = ['$set' => []];
        foreach (get_object_vars($object) as $key => $value) {
            $updateDocument['$set'][$key] = $value;
        }

        return $updateDocument;
    }
}