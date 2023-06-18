<?php

namespace LobsterTest\Lottery\DTO;

class LotteryDTO extends DTO
{
    public ?string $id;
    public int    $start_time;
    public float  $win_chance;
    public string $win_hash;
    public int    $duration;
    public string $lottery_status;
    public int    $restart_times;
    
    public function __construct( $params )
    {
        $this->id             = $params['id'] ?? null;
        $this->start_time     = $params['start_time'] ?? null;
        $this->win_chance     = $params['win_chance'] ?? null;
        $this->win_hash       = $params['win_hash'] ?? null;
        $this->duration       = $params['duration'] ?? null;
        $this->lottery_status = $params['lottery_status'] ?? null;
        $this->restart_times  = $params['restart_times'] ?? null;
    }
    
    /**
     * Change
     *
     * @return array
     */
    public static function filterFields( $fields ): array
    {
        // Filter unwanted
        $fields = array_filter(
            $fields,
            static fn( $field ) => ! in_array( $field['name'], ['id', 'lottery_status', 'win_hash'], true )
        );
        
        // Set title
        $fields = array_map(
            static fn($field) => [
                'name' => $field['name'],
                'title' => str_replace( '_', ' ', ucfirst( $field['name'] ) ),
                'type' => $field['type'] ],
            $fields
        );
        
        // Set HTML type
        return array_map(
            static fn($field) =>
                match( $field['name'] ){
                    'start_time' => [ 'name' => $field['name'], 'type' => 'date', 'title' => $field['title'] ],
                    default      => $field,
                },
            $fields
        );
    }
}