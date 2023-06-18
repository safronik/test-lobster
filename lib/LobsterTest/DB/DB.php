<?php

namespace LobsterTest\DB;

/**
 * DataBase Fabric
 */
class DB
{
    private static DBInterface $db;
    
    public static function get( $db_type = 'file', ?DBConfig $config = null ): DBInterface
    {
        if( isset( self::$db ) ){
            return self::$db;
        }
        
        $db_type === 'pdo' && ! $config
            && throw new \Exception('No DB config provided for PDO DB type');
        
        self::$db = match ( $db_type ){
            'file'  => new FileDB(),
            'pdo'   => new PDO( $config ),
            'debug' => new DebugDB(),
        };
        
        return self::$db;
    }
}