<?php

class Connection
{

    private $pdo;
    private $table;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function get($field, $value)
    {
        $statement = $this->pdo->query('select * from ' . $this->getTable() . ' where ' . $field . ' = ' . $value);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function __destruct()
    {
        $this->pdo = null;
    }

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function isConnected()
    {
        return $this->pdo->query('select 1');
    }
}