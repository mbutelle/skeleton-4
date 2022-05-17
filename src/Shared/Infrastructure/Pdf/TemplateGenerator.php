<?php

namespace App\Shared\Infrastructure\Pdf;

use App\Shared\Infrastructure\Pdf\Generator\TemplateGeneratorInterface;

class TemplateGenerator
{
    /** @var TemplateGeneratorInterface[] */
    private array $generators;

    public function __construct(iterable $pdfGenerators)
    {
        /** @var TemplateGeneratorInterface $templateGenerator */
        foreach ($pdfGenerators as $templateGenerator) {
            $this->generators[$templateGenerator->getTemplateName()] = $templateGenerator;
        }
    }

    public function generate(string $templateName, array $data): string
    {
        if (empty($this->generators[$templateName])) {
            throw new \LogicException(sprintf('No template generator found for "%s"', $templateName));
        }

        return $this->generators[$templateName]->generate($data);
    }
}