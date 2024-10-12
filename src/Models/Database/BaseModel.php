<?php

namespace Akhenaton\Models\Database;

use PDO;
use Akhenaton\Models\Database\Connection;

abstract class BaseModel
{
    protected $table;
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getConnection();
    }

    public function all()
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function findBy($column, $value)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$column} = :value";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_CLASS);
    }

    public function insert($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ':' . implode(", :", array_keys($data));

        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        return $stmt->execute();
    }

    public function update($data, $id)
    {
        $setPart = '';
        foreach ($data as $key => $value) {
            $setPart .= "{$key} = :{$key}, ";
        }
        $setPart = rtrim($setPart, ', ');

        $query = "UPDATE {$this->table} SET {$setPart} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
