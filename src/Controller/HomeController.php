<?php

namespace Trackbox\Controller;

class HomeController
{
    public function index(): void
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
        $twig = new \Twig\Environment($loader);
        
        $database = new \PDO('mysql:host=localhost;dbname=trackbox;charset=utf8', 'root', 'root');
        $query = "SELECT s1.* FROM songs s1
                  INNER JOIN (SELECT name, MAX(version) AS max_version FROM songs GROUP BY name) s2
                  ON s1.name = s2.name AND s1.version = s2.max_version
                  ORDER BY s1.name";
        $files = $database->query($query)->fetchAll(\PDO::FETCH_ASSOC);
        echo $twig->render('home.html.twig', ['files' => $files]);
    }
}
