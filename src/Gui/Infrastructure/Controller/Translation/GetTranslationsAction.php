<?php

declare(strict_types=1);

namespace App\Gui\Infrastructure\Controller\Translation;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\MessageCatalogueInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/translation", methods={"GET"})
 */
final class GetTranslationsAction
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function __invoke()
    {
        /** @var MessageCatalogueInterface $catalog */
        $catalog = $this->translator->getCatalogue('fr');

        return $catalog->all();
    }
}