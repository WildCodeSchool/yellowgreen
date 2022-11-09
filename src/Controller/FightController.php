<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Model\AttackManager;
use App\Model\UnicornManager;

class FightController extends AbstractController
{
    public function index(): string
    {
        $attackManager = new AttackManager();
        $attacks = $attackManager->selectUnicornWithAttacksById($_SESSION["userUnicornId"]);
        $_SESSION['round'] = 1;
        $_SESSION['userScore'] = 100;
        $_SESSION['opponentScore'] = 100;
        return $this->twig->render('Fight/selectAttack.html.twig', ['attacks' => $attacks]);
    }

    public function loopInRound(): string
    {
        $attackManager = new AttackManager();
        $attacks = $attackManager->selectUnicornWithAttacksById($_SESSION["userUnicornId"]);
        return $this->twig->render('Fight/selectAttack.html.twig', ['attacks' => $attacks]);
    }



    public function confirmAttack(): void
    {
        if ($_GET) {
            $_SESSION["userAttackId"] = $_GET["id"];
            $unicornManager = new AttackManager();
            $attacks = $unicornManager->selectUnicornWithAttacksById($_SESSION["opponentUnicornId"]);
            $count = count($attacks);
            $rnd = rand(0, $count - 1);
            $attack = $attacks[$rnd];
            $_SESSION["opponentAttackId"] = $attack['attId'];
            header("location: /round");
        }
    }

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
