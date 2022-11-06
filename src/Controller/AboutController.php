<?php

namespace App\Controller;

class AboutController extends AbstractController
{
    /**
     * Display about page
     */
    public function index(): string
    {
        return $this->twig->render('About/index.html.twig');
    }
}
