<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Utils\UserUtils;
use PDOException;

class RoundController extends AbstractController
{
    public const MAX_SCORE = 200;

    public function fight(?int $round = 0): string
    {
        if ($round == 0) {
            $_SESSION['opponentId'] = 1;
            $_SESSION['opponentUnicornId'] = 1;
            $_SESSION['userUnicornId'] = 2;
            $this->twig->addGlobal('userScore', 100);
            $this->twig->addGlobal('opponentScore', 100);
            $this->twig->addGlobal('round', 10);
        } else {
            $globals = $this->twig->getGlobals();
            if ($round % 10 == 0) {
                $continue = $this->buildRoundUser();
                if (!$continue) {
                    $this->twig->addGlobal('round', 0);
                } else {
                    $this->twig->addGlobal('round', $globals['round'] + 1);
                }
            } else {
                $continue = $this->buildRoundOpponent();
                if ($continue) {
                    $this->twig->addGlobal('round', $globals['round'] + 9);
                } else {
                    $this->twig->addGlobal('round', 0);
                }
            }
        }
        return $this->twig->render("Fight/fight.html.twig");
    }

    private function buildRoundUser(): bool
    {
        $globals = $this->twig->getGlobals();
        $attack = $globals['userAttack'];
        $score = $globals["userScore"];
        $score -= $attack["cost"];
        $success = rand(0, 100) <= $attack["succesRate"];
        if ($success) {
            $score += $attack["gain"];
        }
        $this->twig->addGlobal('successRound', $success);
        $this->twig->addGlobal('userScore', $score);
        return $score > 0 && $score < self::MAX_SCORE;
    }

    private function buildRoundOpponent(): bool
    {
        $globals = $this->twig->getGlobals();
        $attack = $globals['opponentAttack'];
        $score = $globals["opponentScore"];
        $score -= $attack["cost"];
        $success = rand(0, 100) <= $attack["succesRate"];
        if ($success) {
            $score += $attack["gain"];
        }
        $this->twig->addGlobal('successRound', $success);
        $this->twig->addGlobal('opponentScore', $score);
        return $score > 0 && $score < self::MAX_SCORE;
    }
}
