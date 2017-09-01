<?php

class Resource
{
    private $connection;

    /**
     * @return Connection
     */
    public function getConnection()
    {
        if ($this->connection === null) {
            $dns = 'mysql:host=localhost;dbname=graphql';
            $this->connection = new Connection(new \PDO($dns, 'root', ''));
        }

        return $this->connection;
    }
}