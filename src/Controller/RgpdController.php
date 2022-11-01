<?php

namespace App\Controller;

class RgpdController extends AbstractController
{
    /**
     * Display rules page
     */
    public function index(): string
    {
        return $this->twig->render('Rgpd/index.html.twig');
    }
}
