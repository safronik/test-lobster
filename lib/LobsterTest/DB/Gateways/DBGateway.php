<?php

namespace LobsterTest\DB\Gateways;

use LobsterTest\DB\DBInterface;

abstract class DBGateway
{
    protected DBInterface $db;
    
    public function __construct( DBInterface $db )
    {
        $this->db = $db;
    }
}