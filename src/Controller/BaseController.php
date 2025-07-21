<?php

namespace Trackbox\Controller;

class BaseController
{
    protected ?\Twig\Environment $twig = null;

    public function __construct()
    {
        if ($this->twig !== null) {
            return;
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new \Twig\Environment($loader);
    }
}
