<?php

namespace App\Models;

use App\Connections\Database;
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

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function findWhere(array $where): array
    {
        $query = 'select * from ' . $this->getTable() . ' where 1 = 1 ';

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                $whereIn = [];

                foreach ($value as $index => $inValue) {
                    $whereIn[] = ":$field$index";
                }

                $query .= " and $field in (" . implode(', ', $whereIn) . ")";
            } else {
                $query .= ' and ' . $field . '=:' . $field;
            }
        }

        $result = $this->connection->prepare($query);

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                foreach ($value as $index => $inValue) {
                    $result->bindValue($field . $index, $inValue);
                }
            } else {
                $result->bindValue($field, $value);
            }
        }

        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}