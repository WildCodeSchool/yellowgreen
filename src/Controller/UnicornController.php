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
        $unicornManager = new UnicornManager();
        $unicorns = $unicornManager->selectAll("id", "asc");
        return $this->twig->render('Unicorn/index.html.twig', ['post' => $_POST]);
    }
    /**
     * Show informations for a specific unicorn
     */
    public function chooseUnicorn(int $id): string
    {
        $unicornManager = new UnicornManager();
        $unicorn = $unicornManager->selectOneById($id);
        return $this->twig->render('Unicorn/show.html.twig', ['unicorn' => $unicorn]);
    }
}
