<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\UserManager;

class FightController extends AbstractController
{
    //julie index

    public function unicornSelect(): void
    {
        // if (isset($_POST)) {
        //     $enemyId = self::cleanParam($_POST['enemyId']);
        // }
    }

    public function index(): string
    {
        return $this->twig->render('Fight/index.html.twig');
    }
}
