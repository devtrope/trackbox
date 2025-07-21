<?php

use Trackbox\Controller\HomeController;

require __DIR__ . '/../vendor/autoload.php';

$homeController = new HomeController();
$homeController->index();