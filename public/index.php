<?php

use Trackbox\Controller\FilesController;
use Trackbox\Controller\HomeController;
use Trackbox\Controller\UploadController;

require __DIR__ . '/../vendor/autoload.php';

define('PUBLIC_ROOT',  __DIR__);

$router = new \Trackbox\Router\Router();

$router->get('/', function () {
    (new HomeController())->index();
});

$router->get('/files', function () {
    (new FilesController())->index();
});

$router->post('/upload', function () {
    (new UploadController())->index();
});
;
$router->dispatch();