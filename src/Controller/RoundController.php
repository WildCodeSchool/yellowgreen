<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Utils\UserUtils;
use PDOException;

class RoundController extends AbstractController
{
    public const MAX_SCORE = 200;

    public function fight(): string|null
    {
        $globals = $this->twig->getGlobals();

        $continue = $this->buildRoundUser();

        if ($continue) {
            $continue = $this->buildRoundOpponent();
            if ($continue) {
                $_SESSION['round'] = $globals['round'] + 1;
                header("location: /loopInRound");
                return null;
            } else {
                $_SESSION['round'] = 0;
                return $this->twig->render("Fight/index.html.twig");
            }
        } else {
            $_SESSION['round'] = 0;
            return $this->twig->render("Fight/index.html.twig");
        }
    }

    private function buildRoundUser(): bool
    {
        $globals = $this->twig->getGlobals();
        $attack = $globals['userAttack'];
        $score = $globals["userScore"];
        $score -= $attack["cost"];
        $success = rand(0, 100) <= $attack["successRate"];
        if ($success) {
            $score += $attack["gain"];
        }
        $_SESSION['successRound'] =  $success;
        $_SESSION['userScore'] = $score;
        return $score > 0 && $score < self::MAX_SCORE;
    }

    private function buildRoundOpponent(): bool
    {
        $globals = $this->twig->getGlobals();
        $attack = $globals['opponentAttack'];
        $score = $globals["opponentScore"];
        $score -= $attack["cost"];
        $success = rand(0, 100) <= $attack["successRate"];
        if ($success) {
            $score += $attack["gain"];
        }
        $_SESSION['successRound'] =  $success;
        $_SESSION['opponentScore'] = $score;
        return $score > 0 && $score < self::MAX_SCORE;
    }
}
