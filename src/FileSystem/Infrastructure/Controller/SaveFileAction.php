<?php

declare(strict_types=1);

namespace App\FileSystem\Infrastructure\Controller;

use App\FileSystem\Application\Command\SaveFile\SaveFileCommand;
use App\Shared\Infrastructure\Bus\Command\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("", methods={"POST"})
 */
final class SaveFileAction
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): SaveFileCommand
    {
        if (!$request->files->has('file')) {
            throw new BadRequestHttpException('parameter.file.required');
        }

        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        $saveFileCommand = new SaveFileCommand(
            Uuid::uuid6()->toString(),
            $file->getFilename(),
            $file->getMimeType(),
            base64_encode($file->getContent())
        );

        $this->bus->handle($saveFileCommand);

        return $saveFileCommand;
    }
}