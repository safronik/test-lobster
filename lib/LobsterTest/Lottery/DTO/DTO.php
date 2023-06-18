<?php

namespace LobsterTest\Lottery\DTO;

abstract class DTO
{
    public static function getFields( bool $filter = false ): array
    {
        $reflection = new \ReflectionClass( static::class );
        $fields = array_map(
            fn($property_reflection) => [
                'name' => $property_reflection->name,
                'type' => $property_reflection->getType()->allowsNull()
                    ? 'string'
                    : $property_reflection->getType()->getName(),
            ],
            $reflection->getProperties()
        );
        
        return $filter && method_exists( static::class, 'filterFields' )
            ? static::filterFields( $fields )
            : $fields;
    }
}