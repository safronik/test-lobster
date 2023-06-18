<?php

namespace LobsterTest\Variables;

use LobsterTest\CodeTemplates\Multiton;

define('INT', 'int');
define('FLOAT', 'float');
define('STR', 'string');
define('ARRAY', 'array');
define('OBJECT', 'object');

abstract class Variables{
    
    use Multiton;
 
    protected array $variables;
    
	abstract protected function getVariable( $name );
	abstract protected function getAllVariablesNames();
 
	public static function get( $name, $type = null ): mixed
    {
    
		$self  = static::getInstance();
        $value = $self->recall( $name ) ?? $self->getVariable( $name );
        $value = isset( $type ) ? static::castType( $value, $type) : $value;
        isset( $value ) && $self->rememberVariable( $name, $value );
        
        return $value;
	}
	
    private static function castType( $value, $type ): mixed
    {
        return match ( $type ) {
            'int'    => (int) $value,
            'float'  => (float) $value,
            'string' => (string) $value,
            default  => (string) $value,
        };
    }
    
    public static function getAllVariables(): array
    {
        $self = static::getInstance();
        
        foreach( $self->getAllVariablesNames() as $variable_name ){
            $self->variables[ $variable_name ] = $self->getVariable( $variable_name );
        }
        
        return $self->variables;
    }
    
	private function recall( $name ): mixed
    {
		return $this->variables[ static::class ][ $name ] ?? null;
	}
	
	private function rememberVariable( $name, $value ): void
    {
		$this->variables[ static::class ][ $name ] = $value;
	}
}