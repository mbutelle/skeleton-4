<?php

declare(strict_types=1);

namespace App\FileSystem\Infrastructure\Controller;

use App\FileSystem\Application\Command\SaveFile\SaveFileCommand;
use App\FileSystem\Application\Command\SaveFiles\SaveFilesCommand;
use App\Shared\Infrastructure\Bus\Command\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/multiple", methods={"POST"})
 */
final class SaveFilesAction
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): SaveFilesCommand
    {
        if (!$request->files->has('files')) {
            throw new BadRequestHttpException('parameter.files.required');
        }

        /** @var UploadedFile[] $files */
        $files = $request->files->get('files');

        $subCommands = [];
        foreach ($files as $file) {
            $subCommands[] = new SaveFileCommand(
                Uuid::uuid6()->toString(),
                $file->getFilename(),
                $file->getMimeType(),
                base64_encode($file->getContent())
            );
        }
        $saveFilesCommand = new SaveFilesCommand($subCommands);

        $this->bus->handle($saveFilesCommand);

        return $saveFilesCommand;
    }
}