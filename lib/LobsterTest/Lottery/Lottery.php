<?php

namespace LobsterTest\Lottery;

use LobsterTest\Lottery\Interfaces\LotteryDBInterface;
use LobsterTest\Lottery\DTO\LotteryDTO;

class Lottery
{
    private LotteryDBInterface $gateway;
    
    private string $id;
    private string $win_hash;
    private int    $duration;
    private int    $start_time;
    private float  $win_chance;
    public string  $lottery_status;
    public string  $temp_status;
    public int     $restart_times;
    
    public function __construct( LotteryDBInterface $gateway, $id = null )
    {
        $this->gateway = $gateway;
        
        $id && $this->initLottery( $id );
    }
    
    private function initLottery( $id ): void
    {
        $lottery_dto = $this->gateway->getLottery( $id );
        $lottery_dto
            || throw new \Exception( 'No lottery found for id ' . $id );
        
        $this->id             = $lottery_dto->id;
        $this->start_time     = $lottery_dto->start_time;
        $this->win_chance     = $lottery_dto->win_chance;
        $this->win_hash       = $lottery_dto->win_hash;
        $this->duration       = $lottery_dto->duration;
        $this->lottery_status = $lottery_dto->lottery_status;
        $this->restart_times  = $lottery_dto->restart_times;
        
          $this->timeToRestart() &&   $this->canBeRestarted()   && $this->restart(); // Restart
        ( $this->timeToRestart() && ! $this->canBeRestarted() ) && $this->stop();    // Stop other way
    }
    
    public function startLottery(
        float $win_chance = 1 / 10000,
        int $duration = 60 * 60 * 24 * 7,
        ?int $lottery_start_time = null,
        int $restart_times = 0
    ): bool
    {
        $this->id             = trim( com_create_guid(), '{}');
        $this->start_time     = $lottery_start_time ?? time();
        $this->win_chance     = $win_chance;
        $this->win_hash       = hash( 'sha256', random_int( 1, 1 / $win_chance ) );
        $this->duration       = $duration;
        $this->lottery_status = 'IN_PROCESS';
        $this->restart_times  = $restart_times;
        
        return $this->save();
    }
    
    private function timeToRestart()
    {
        return $this->start_time + $this->duration < time();
    }
    
    private function canBeRestarted()
    {
        return $this->restart_times - 1 >= 0;
    }
    
    public function restart()
    {
        
        if( $this->restart_times - 1 >= 0 ){
            $new_lottery = new self( $this->gateway );
            $new_lottery->startLottery(
                $this->win_chance,
                $this->duration,
                $this->start_time + $this->duration,
                $this->restart_times - 1
            );
        }
        
        $this->stop();
        
        // Reload page
        header("Refresh:0");
    }
    
    public function isRollInProgress(): bool
    {
        return $this->lottery_status !== 'IN_PROCESS';
    }
    
    public function stop(): bool
    {
        $this->lottery_status = 'STOPPED';
        
        return $this->save();
    }
    
    public function pause(): bool
    {
        $this->temp_status    = $this->lottery_status;
        $this->lottery_status = 'PAUSED';
        
        return $this->save();
    }
    
    public function resume(): bool
    {
        $this->lottery_status = 'IN_PROCESS';
        
        return $this->save();
    }
    
    private function save(): bool
    {
        return $this->gateway->saveLottery(
            new LotteryDTO([
                'id'             => $this->id,
                'start_time'     => $this->start_time,
                'win_chance'     => $this->win_chance,
                'win_hash'       => $this->win_hash,
                'duration'       => $this->duration,
                'lottery_status' => $this->lottery_status,
                'restart_times'  => $this->restart_times,
            ])
        );
    }
    
    public function isParticipantWinner( Participant $participant ): bool
    {
        return $this->win_hash === $participant->getHash();
    }
    
    public function hasWinner(): bool
    {
        return $this->gateway->hasWinner(
            $this->id,
            $this->win_hash
        );
    }
    
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getWinChance(): float
    {
        return $this->win_chance;
    }
}