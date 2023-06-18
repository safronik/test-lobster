<?php

namespace LobsterTest\DB;

class PDO implements DBInterface
{
    private \PDO $pdo;
    
    public function __construct( DBConfig $config )
    {
        $this->pdo = new \PDO(
            $config->dsn,
            $config->username,
            $config->password,
            array(
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION, // Handle errors as an exceptions
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC     // Set default fetch mode as associative array
            )
        );
    }
    
    public function insert( $query ): int|string
    {
        return $this->pdo->query( $query )->rowCount();
    }
    
    public function select( $query ): array
    {
        return $this->pdo->query( $query )->fetchAll();
    }
    
    public function update( $query ): int|string
    {
        return $this->pdo->query( $query )->rowCount();
    }
    
    public function delete( $query ): int|string
    {
        return $this->pdo->query( $query )->rowCount();
    }
}