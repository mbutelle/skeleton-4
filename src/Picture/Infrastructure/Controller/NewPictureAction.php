<?php

declare(strict_types=1);

namespace App\Picture\Infrastructure\Controller;

use App\Picture\Application\Command\NewPicture\NewPictureCommand;
use App\Picture\Domain\Model\PictureReferenceGeneratorInterface;
use App\Picture\Infrastructure\Dto\Input\Picture;
use App\Shared\Infrastructure\Bus\Command\CommandBus;
use App\Shared\Infrastructure\Validation\Exception\ValidationException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/', name: 'new_picture', methods: 'POST')]
final class NewPictureAction
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private CommandBus $bus;
    private PictureReferenceGeneratorInterface $pictureReferenceGenerator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator, CommandBus $bus, PictureReferenceGeneratorInterface $pictureReferenceGenerator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->bus = $bus;
        $this->pictureReferenceGenerator = $pictureReferenceGenerator;
    }

    public function __invoke(Request $request): NewPictureCommand
    {
        $picture = $this->serializer->deserialize($request->getContent(), Picture::class, 'json');

        $violations = $this->validator->validate($picture);
        if (
            !$picture instanceof Picture
            || 0 < $violations->count()
        ) {
            throw new ValidationException($violations);
        }

        $command = new NewPictureCommand(
            $this->pictureReferenceGenerator->generate(),
            $picture->file,
            $picture->author,
            $picture->description,
        );

        $this->bus->handle($command);

        return $command;
    }
}