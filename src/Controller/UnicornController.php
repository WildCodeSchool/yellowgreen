<?php

namespace App\Controller;

use App\Model\UnicornManager;

class UnicornController extends AbstractController
{
    /**
     * List users
     */
    public function index(): string
    {
        return $this->twig->render('Fight/select-unicorn.html.twig', ['post' => $_POST]);
    }
    /**
     * Show informations for a specific unicorn
     */
    public function addSelectedUnicornToSession(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cleanValue = htmlentities(trim($_POST["selectedUnicorn"]));
            $cleanIdUnicorn = intval($cleanValue);
            if (filter_var($cleanIdUnicorn, FILTER_VALIDATE_INT)) {
                $unicornManager = new UnicornManager();
                $unicorn = $unicornManager->selectOneById($cleanIdUnicorn);
                $_SESSION['selectedUnicorn'] = $unicorn["id"];
            }
            $cleanValue = htmlentities(trim($_POST["opponentUnicorn"]));
            $cleanIdUnicorn = intval($cleanValue);
            if (filter_var($cleanIdUnicorn, FILTER_VALIDATE_INT)) {
                $unicornManager = new UnicornManager();
                $unicorn = $unicornManager->selectOneById($cleanIdUnicorn);
                $_SESSION['opponentUnicorn'] = $unicorn["id"];
                header("location: /select-unicorn");
            }
        } else {
            header("location: /");
        }
    }

    /**
     * It's computer turn to pick a unicorn
     * Implement a function that removes the unicorn chosen by the user from the available choice list
     * Implement a function that randomizes the choice
     * Save the choice to a $_SESSION var
    */
}
