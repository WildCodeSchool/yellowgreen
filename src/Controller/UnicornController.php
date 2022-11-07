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
        return $this->twig->render('Unicorn/index.html.twig', ['post' => $_POST]);
    }
    /**
     * Show informations for a specific unicorn
     */
    public function addSelectedUnicornToSession(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cleanId = htmlentities(trim($_POST["selectedUnicorn"]));
            if (filter_var($cleanId, FILTER_VALIDATE_INT)) {
                $unicornManager = new UnicornManager();
                $unicorn = $unicornManager->selectOneById($cleanId);
                $_SESSION['selectedUnicorn'] = $unicorn["id"];
                header("location: /unicorn");
            }
        } else {
            header("location: /");
        }
    }
}
