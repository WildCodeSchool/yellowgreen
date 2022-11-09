<?php

namespace App\Controller;

use App\Model\UnicornManager;

class FightController extends AbstractController
{
    /**
     * Display about page
     */
    public function index(): string
    {
        $unicornManager = new UnicornManager();
        $unicorn = $unicornManager->selectUnicornWithAttacksById(1);
        return $this->twig->render('Fight/selectAttack.html.twig', ['unicorn' => $unicorn]);
    }
}
