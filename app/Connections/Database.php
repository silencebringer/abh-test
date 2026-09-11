<?php

namespace App\Connections;

use PDO;

class Database extends Connection
{
    public static function connection()
    {
        if (!self::$connection) {
            $config = require __DIR__ . '/../../config.php';

            self::$connection = new PDO(
                "mysql:host={$config['database']['host']};dbname={$config['database']['database']}",
                $config['database']['username'],
                $config['database']['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        }

        return self::$connection;
    }
}