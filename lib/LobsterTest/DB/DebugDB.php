<?php

namespace LobsterTest\DB;

class DebugDB implements DBInterface
{
    
    public function insert( $query ): int|string
    {
        // TODO: Implement insert() method.
    }
    
    public function select( $query ): array
    {
        return [];
    }
    
    public function update( $query ): int|string
    {
        // TODO: Implement update() method.
    }
    
    public function delete( $query ): int|string
    {
        // TODO: Implement delete() method.
    }
}