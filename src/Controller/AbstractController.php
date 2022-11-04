<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Model\UserManager;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected array|false $sessionUser = false;

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
            $this->sessionUser = $userManager->selectOneById($_SESSION["userId"]);
            $this->twig->addGlobal('sessionUser', $this->sessionUser);
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
