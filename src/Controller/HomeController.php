<?php

namespace Trackbox\Controller;

class HomeController
{
    public function index(): void
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $twig = new \Twig\Environment($loader);
        
        echo $twig->render('home.html.twig');
    }
}
