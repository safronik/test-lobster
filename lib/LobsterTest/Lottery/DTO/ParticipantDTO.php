<?php

namespace LobsterTest\Lottery\DTO;

class ParticipantDTO
{
    public string $ip;
    public string $lottery_id;
    public ?string $hash;
    public ?int    $roll_time;
    
    public function __construct( $params )
    {
        $this->ip         = $params['ip'] ?? null;
        $this->lottery_id = $params['lottery_id'] ?? null;
        $this->hash       = $params['hash'] ?? '';
        $this->roll_time  = $params['roll_time'] ?? 0;
    }
}