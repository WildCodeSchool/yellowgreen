<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Model\UserManager;
use App\Model\UnicornManager;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected array|false $user = false;
    protected array|false $unicorn = false;
    protected array|false $opponentUnicorn = false;


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

        if (isset($_SESSION["userId"])) {
            $userManager = new UserManager();
            $this->user = $userManager->selectOneById($_SESSION["userId"]);
            $this->twig->addGlobal('sessionUser', $this->user);
        }
        if (isset($_SESSION["selectedUnicorn"])) {
            $unicornManager = new UnicornManager();
            $this->unicorn = $unicornManager->selectOneById($_SESSION["selectedUnicorn"]);
            $this->twig->addGlobal('unicorn', $this->unicorn);
        }

        if (isset($_SESSION["opponentUnicorn"])) {
            $unicornManager = new UnicornManager();
            $this->opponentUnicorn = $unicornManager->selectOneById($_SESSION["opponentUnicorn"]);
            $this->twig->addGlobal('opponentUnicorn', $this->opponentUnicorn);
        }
    }
}
