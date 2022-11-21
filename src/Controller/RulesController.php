<?php

namespace App\Controller;

class RulesController extends AbstractController
{
    /**
     * Display rules page
     */
    public function index(): string
    {
        return $this->twig->render('Rules/index.html.twig');
    }
}
