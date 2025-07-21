<?php

namespace Trackbox\Config;

class Database
{
    private static ?\PDO $instance = null;

    public static function getConnection(): \PDO
    {
        if (self::$instance === null) {
            self::$instance = new \PDO('mysql:host=localhost;dbname=trackbox;charset=utf8', 'root', 'root');
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        
        return self::$instance;
    }
}
