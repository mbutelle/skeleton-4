<?php

namespace App\Shared\Infrastructure\Pdf\Generator;

interface TemplateGeneratorInterface
{
    public function getTemplateName(): string;
    public function generate(array $data = []): string;
}