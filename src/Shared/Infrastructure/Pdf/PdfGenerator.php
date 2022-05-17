<?php

namespace App\Shared\Infrastructure\Pdf;

use Knp\Snappy\Pdf;

class PdfGenerator
{
    private Pdf $pdf;
    private TemplateGenerator $templateGenerator;

    public function __construct(Pdf $pdf, TemplateGenerator $templateGenerator)
    {
        $this->pdf = $pdf;
        $this->templateGenerator = $templateGenerator;
    }

    public function generate(string $templateName, array $data = []): string
    {
        $input = $this->templateGenerator->generate($templateName, $data);

        return  $this->pdf->getOutputFromHtml($input);
    }
}