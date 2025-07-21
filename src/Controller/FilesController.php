<?php

namespace Trackbox\Controller;

class FilesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): void
    {
        $database = new \PDO('mysql:host=localhost;dbname=trackbox;charset=utf8', 'root', 'root');

            $query = "SELECT s1.* FROM songs s1
                    INNER JOIN (SELECT name, MAX(version) AS max_version FROM songs GROUP BY name) s2
                    ON s1.name = s2.name AND s1.version = s2.max_version
                    ORDER BY s1.name";
            $files = $database->query($query)->fetchAll(\PDO::FETCH_ASSOC);
            
        echo $this->twig->render('files.html.twig', ['files' => $files]);
    }
}
