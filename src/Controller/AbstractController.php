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
    protected array|false $user = false;

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
        
        if(isset($_SESSION["userId"])){
            $userManager = new UserManager();
            $this->user = $userManager->selectOneById($_SESSION["userId"]);
            $this->twig->addGlobal('user', $this->user);
        }
    }

    public static function cleanParam(mixed $param): mixed
    {
        switch (gettype($param)) {
            case "string":
                $param = htmlentities(trim($param));
                break;
            case "integer":
                $param = filter_var($param, FILTER_VALIDATE_INT);
                break;
            case "double":
                $param = filter_var($param, FILTER_VALIDATE_FLOAT);
                break;
            case "boolean":
                $param = filter_var($param, FILTER_VALIDATE_BOOLEAN);
                break;
            case "array":
                $newParam = array();
                foreach ($param as $key => $value) {
                    $newParam[$key] = self::cleanParam($value);
                }
                $param = $newParam;
                break;
            default:
                $param = false;
        }
        return $param;
    }


}
