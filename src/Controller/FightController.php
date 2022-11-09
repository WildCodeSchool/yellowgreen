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
        return $this->twig->render('Fight/selectAttack.html.twig', ["type" => "user", 'attacks' => $attacks]);
    }

    public function confirmUserAttack(): array
    {
        $_SESSION["userAttackId"] = $_GET["id"];
        $unicornManager = new AttackManager();
        $attacks = $unicornManager->selectUnicornWithAttacksById($_SESSION["opponentUnicornId"]);
        return $attacks;
    }

    public function confirmOpponentAttack(): void
    {
        $_SESSION["opponentAttackId"] = $_GET["id"];
    }

    public function confirmAttack(): string|null
    {

        if ($_GET) {
            if ($_GET['type'] === 'user') {
                $attacks = $this->confirmUserAttack();
                return $this->twig->render('Fight/selectAttack.html.twig', [
                    "type" => "opponent",
                    'attacks' => $attacks
                ]);
            } else {
                $this->confirmOpponentAttack();
                header("location: /");
                return null;
            }
        }
        return null;
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
