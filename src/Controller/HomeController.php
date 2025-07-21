<?php

namespace Trackbox\Controller;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): void
    {
        echo $this->twig->render('home.html.twig');
    }
}
