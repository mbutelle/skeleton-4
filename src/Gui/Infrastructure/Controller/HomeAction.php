<?php

declare(strict_types=1);

namespace App\Gui\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'homepage', methods: 'GET')]
final class HomeAction extends AbstractController
{
    public function __invoke()
    {
        return $this->render('default/index.html.twig');
    }
}