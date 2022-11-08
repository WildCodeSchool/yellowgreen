<?php

namespace App\Controller;

use App\Model\UserManager;

class FightController extends AbstractController
{
    public function selectRandomUsers(): string
    {
        $userManager = new UserManager();
        $users = $userManager->selectRandomUsers();
        $opponentPicture = 'img_avatar.png';
        if (isset($_GET["id"])) {
            $id = $_GET['id'];
            $selectedFighter = $userManager->selectOneById($id);
            $opponentPicture = $selectedFighter['avatar'];
        }



        return $this->twig->render('Fight/index.html.twig', [
            'users' => $users,
            'opponentPicture' => $opponentPicture
        ]);
    }

    public function selectOpponent(int $id): string
    {
        $userManager = new UserManager();
        $selectedFighter = $userManager->selectOneById($id);




        return $this->twig->render('Fight/index.html.twig', [
        'fighter' => $selectedFighter
        ]);
    }
}
