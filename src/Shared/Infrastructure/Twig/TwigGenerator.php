<?php

namespace App\Shared\Infrastructure\Twig;

use Twig\Environment;

final class TwigGenerator
{
    const EMAIL = 'email';
    const PDF = 'pdf';

    const FORMAT_HTML = 'html';

    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $type
     * @param string $template
     * @param array  $data
     *
     * @return string
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $type, string $template, array $data, string $format = self::FORMAT_HTML): string
    {
        return $this->twig->render(sprintf('%s/%s.%s.twig', $type, $template, $format), $data);
    }
}