<?php

namespace App\Shared\Infrastructure\Validation\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends BadRequestHttpException
{
    public function __construct(ConstraintViolationListInterface $constraintViolationList, \Throwable $previous = null, int $code = 400, array $headers = [])
    {
        $violations = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($constraintViolationList as $violation) {
            $violations[$violation->getPropertyPath()] = $violation->getMessage();
        }

        parent::__construct(json_encode($violations), $previous, $code, $headers);
    }
}
