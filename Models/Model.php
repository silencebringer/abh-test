<?php

namespace Models;

use Connections\Database;
use Exception;
use PDO;

abstract class Model
{
    protected $connection;

    protected $table;

    public function __construct()
    {
        $this->connection = Database::connection();
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
        $query = "select * from " . $this->getTable();
        $result = $this->connection->query($query);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $query = "select * from " . $this->getTable() . " where id=:id";

        $result = $this->connection->prepare($query);
        $result->execute(['id' => $id]);

        return $result->fetch();
    }
}