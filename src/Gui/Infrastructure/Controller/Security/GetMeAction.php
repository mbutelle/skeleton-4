<?php

declare(strict_types=1);

namespace App\Gui\Infrastructure\Controller\Security;

use App\Gui\Infrastructure\Dto\Security\Me;
use App\Security\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/me", methods={"GET"})
 */
final class GetMeAction extends AbstractController
{
    public function __invoke(): Me
    {
        /** @var User $user */
        $user = $this->getUser();

        return new Me($user);
    }
}