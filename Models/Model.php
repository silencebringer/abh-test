<?php

namespace Models;

use Exception;
use PDO;

abstract class Model
{
    protected $connection;

    protected $table;

    public function __construct()
    {
        $config = require __DIR__ . '/../config.php';

        $this->connection = new PDO(
            "mysql:host={$config['database']['host']};dbname={$config['database']['database']}",
            $config['database']['username'],
            $config['database']['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    }

    public function getTable(): string
    {
        if (!$this->table) {
            throw new Exception('Table name is not specified');
        }

        return $this->table;
    }

    public function all(): array
    {
        $query = "SELECT * FROM " . $this->getTable();
        $result = $this->connection->query($query);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}