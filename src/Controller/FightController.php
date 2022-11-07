<?php

namespace App\Controller;

use App\Model\UserManager;

class FightController extends AbstractController
{
    /**
     * Display home page
     */

    public function selectRandomUsers(): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectRandomUsers();
        var_dump($user);
        die;
        return $this->twig->render('Fight/index.html.twig', ['user' => $user]);
    }
}
