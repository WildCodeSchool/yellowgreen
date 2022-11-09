<?php

namespace App\Controller;

use App\Model\UserManager;

class FightController extends AbstractController
{
    public function selectRandomUsers(): string
    {
        $globals = $this->twig->getGlobals();
        $userManager = new UserManager();
        $user = $globals['sessionUser'];
        $users = $userManager->selectRandomUsers($user['id']);
        $selectedFighter = array();
        $selectedFighter['avatar'] = "img_avatar.png";

        if (isset($_GET["id"])) {
            $id = $_GET['id'];
            $selectedFighter = $userManager->selectOneById($id);
        }

        return $this->twig->render('Fight/index.html.twig', [
            'users' => $users,
            'opponent' => $selectedFighter
        ]);
    }

    public function confirmOpponent()
    {
        if ($_POST) {
            $_SESSION['opponentUserId'] = $_POST['opponentId'];
            header("Location: /select-unicorn");
            return null;
        }
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
