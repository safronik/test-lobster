<?php

namespace LobsterTest\Lottery;

use LobsterTest\Lottery\Interfaces\ParticipantDBInterface;
use LobsterTest\Lottery\DTO\ParticipantDTO;

class Participant
{
    private string $ip;
    private string $lottery_id;
    private ?string $hash      = null;
    private ?int    $roll_time = null;
    private Lottery $lottery;
    private ParticipantDBInterface $gateway;
    
    public function __construct( ParticipantDBInterface $gateway, $lottery, $ip )
    {
        $this->gateway = $gateway;
        $this->lottery = $lottery;
        $this->initParticipant( $ip, $lottery ) || $this->register( $ip );
    }
    
    private function initParticipant( string $ip, Lottery $lottery ): bool
    {
        $participant_dto = $this->gateway->getParticipant( $ip, $lottery->getId() );
        
        if( ! $participant_dto instanceof ParticipantDTO ){
            return false;
        }
        
        $this->ip         = $participant_dto->ip;
        $this->lottery_id = $participant_dto->lottery_id;
        $this->hash       = $participant_dto->hash;
        $this->roll_time  = $participant_dto->roll_time;
        
        return true;
    }

    public function register( $ip ): void
    {
        $this->ip         = $ip;
        $this->lottery_id = $this->lottery->getId();
        $this->hash       = '';
        
        $this->save();
    }
    
    public function allowedToRoll(): bool
    {
        return ! $this->hash;
    }
    
    public function roll(): void
    {
        $this->roll_time  = time();
        $this->hash       = hash( 'sha256', random_int( 1, 1 / $this->lottery->getWinChance() ) );
        
        $this->save();
    }
    
    private function save(): bool
    {
        return $this->gateway->saveParticipant(
            new ParticipantDTO([
                'ip'         => $this->ip,
                'lottery_id' => $this->lottery_id,
                'hash'       => $this->hash,
                'roll_time'  => $this->roll_time,
            ])
        );
    }
    
    private function convertToArray(): array
    {
        $out = [];
        foreach( $this as $key => $val ){
            $out[ $key ] = $val;
        }
        
        return $out;
    }
    
    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}