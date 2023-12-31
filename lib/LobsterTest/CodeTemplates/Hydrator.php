<?php

namespace LobsterTest\CodeTemplates;

/**
 * Class Hydrator
 *
 * Data Transfer Object
 *
 * Should extend the specific class  as trait for usage
 * Checks if the property exists and cast it to its default type
 *
 * @version 1.0.0
 */
trait Hydrator
{
    /**
     * @param $params
     *
     * @return void
     */
    public function hydrateFrom( $params = array() ): void
    {
        foreach ( $params as $param_name => $param ) {
            
            if ( property_exists(static::class, $param_name) ) {
                
                $type = isset( $this->$param_name )
                    ? strtolower( gettype($this->$param_name) )
                    : 'null';
                
                $this->$param_name = $param;
				
				// Skip type casting for default undefined properties
				if( $type === 'null' ){
					continue;
				}
				
                settype($this->$param_name, $type);
            }
        }
    }
}
