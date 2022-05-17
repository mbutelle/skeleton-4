<?php

declare(strict_types=1);

namespace App\Gui\Infrastructure\Controller\Security;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/logout", name="logout")
 */
final class LogoutAction
{
    public function __invoke()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}