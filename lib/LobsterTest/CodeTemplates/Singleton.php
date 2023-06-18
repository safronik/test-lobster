<?php

namespace LobsterTest\CodeTemplates;

trait Singleton
{
    /**
     * @var mixed
     */
    private static self $instance;
    
    /**
     * Constructor
     *
     * @param array $params Additional parameters to pass in the method initialize()
     *
     * @return mixed|\static
     */
    public static function getInstance( ...$params ): static
    {
        return self::$instance ?? self::$instance = new static( ...$params );
    }
    
    public static function isInitialized(): bool
    {
        return isset( static::$instance );
    }
}
