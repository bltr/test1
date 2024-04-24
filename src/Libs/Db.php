<?php

namespace App\Libs;

use PDO;

class Db
{
    private static PDO $pdo;

    public static function getPdo(): PDO
    {
        if (!isset(static::$pdo)) {
            $database = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASSWORD');

            static::$pdo = new PDO("pgsql:host=db;port=5432;dbname={$database};user={$user};password={$password}");
        }

        return static::$pdo;
    }
}
