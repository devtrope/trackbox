<?php

use Trackbox\Controller\FilesController;
use Trackbox\Controller\HomeController;
use Trackbox\Controller\UploadController;

require __DIR__ . '/../vendor/autoload.php';

define('PUBLIC_ROOT',  __DIR__);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/') {
    $homeController = new HomeController();
    $homeController->index();
    exit;
}

if ($uri === '/upload') {
    $uploadController = new UploadController();
    $uploadController->index();
    exit;
}

if ($uri === '/files') {
    $filesController = new FilesController();
    $filesController->index();
    exit;
}