<?php

namespace App\Controller;

use App\Model\AttackManager;
use App\Model\UnicornManager;

class FightController extends AbstractController
{
    /**
     * Display about page
     */
    public function index(): string
    {
        $unicornManager = new AttackManager();
        $attacks = $unicornManager->selectUnicornWithAttacksById($_SESSION["userUnicornId"]);
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
            if ($_GET['type'] == 'user') {
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
}
