<?php

namespace App\Controller;

class RulesController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('Rules/index.html.twig');
    }
}