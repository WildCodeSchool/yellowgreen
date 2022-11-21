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
            }
        }

        $user = $globals['sessionUser'];
        $opponent = $globals['opponentUser'];
        if ($_SESSION['userScore'] > $_SESSION['opponentScore']) {
            $user['score'] += (int) ($opponent['score'] / 10);
            $userDb = new UserManager();
            $userDb->updateScore($user);
        } else {
            $opponent['score'] += (int) ($user['score'] / 10);
            $userDb = new UserManager();
            $userDb->updateScore($opponent);
        }
        $_SESSION['round'] = 0;
        header("location: /fight");
        return null;
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
