<?php

namespace LobsterTest\DB;

// DB CRUD Interface
interface DBInterface
{
    public function insert( $query ): int|string;
    public function select( $query ): array;
    public function update( $query ): int|string;
    public function delete( $query ): int|string;
}