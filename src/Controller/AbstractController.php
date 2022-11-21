<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Model\UserManager;
use App\Model\UnicornManager;
use App\Model\AttackManager;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => true,
            ]
        );

        $this->twig->addExtension(new DebugExtension());


        if ($_SESSION) {
            foreach ($_SESSION as $key => $value) {
                switch ($key) {
                    case "userId":
                        $userManager = new UserManager();
                        $sessionUser = $userManager->selectOneById($value);
                        $this->twig->addGlobal('sessionUser', $sessionUser);
                        $unicornManager = new UnicornManager();
                        $unicorns = $unicornManager->selectAll();
                        $this->twig->addGlobal('unicorns', $unicorns);
                        break;
                    case "opponentUserId":
                        $userManager = new UserManager();
                        $opponentUser = $userManager->selectOneById($value);
                        $this->twig->addGlobal('opponentUser', $opponentUser);
                        break;
                    case "userUnicornId":
                        $unicornManager = new UnicornManager();
                        $userUnicorn = $unicornManager->selectOneById($value);
                        $this->twig->addGlobal('userUnicorn', $userUnicorn);
                        break;
                    case "opponentUnicornId":
                        $unicornManager = new UnicornManager();
                        $opponentUnicorn = $unicornManager->selectOneById($value);
                        $this->twig->addGlobal('opponentUnicorn', $opponentUnicorn);
                        break;
                    case "userAttackId":
                        $attackManager = new attackManager();
                        $userAttack = $attackManager->selectOneById($value);
                        $this->twig->addGlobal('userAttack', $userAttack);
                        break;
                    case "opponentAttackId":
                        $attackManager = new attackManager();
                        $opponentAttack = $attackManager->selectOneById($value);
                        $this->twig->addGlobal('opponentAttack', $opponentAttack);
                        break;
                    case "userScore":
                        $this->twig->addGlobal('userScore', $_SESSION['userScore']);
                        break;
                    case "opponentScore":
                        $this->twig->addGlobal('opponentScore', $_SESSION['opponentScore']);
                        break;
                    case "round":
                        $this->twig->addGlobal('round', $_SESSION['round']);
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function cleanParam(mixed $value): mixed
    {
        switch (gettype($value)) {
            case "integer":
                $value = filter_var($value, FILTER_VALIDATE_INT);
                break;
            case "boolean":
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                break;
            case "double":
                $value = filter_var($value);
                break;
            case "string":
                $value = htmlentities($value);
                break;
            case "array":
                foreach ($value as $val) {
                    $val = $this->cleanParam($val);
                }
                break;
            default:
        }
        return $value;
    }
}
