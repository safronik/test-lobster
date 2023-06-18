<?php

namespace LobsterTest\Lottery;

class LotteryDrawing
{
    public Lottery     $lottery;
    public Participant $participant;
    private string     $participant_ip;
    
    public function __construct( Lottery $lottery, Participant $participant )
    {
        $this->lottery        = $lottery;
        $this->participant    = $participant;
    }
    
    public function roll(): bool
    {
        if( $this->lottery->hasWinner() ){
            return false;
        }
        
        $this->participant->allowedToRoll()
            || throw new \Exception('No second chance are available');
        
        // Transaction
        
        $this->lottery->isRollInProgress()
            || throw new \Exception('Failed to roll, because transaction is in progress');
        
         $this->lottery->pause();
        
        try{
            $this->participant->roll();
            
            $won = $this->lottery->isParticipantWinner( $this->participant );
            
            $this->lottery->resume();
            
        }catch(\Exception $exception){
            echo 'Error occurred during lottery drawing: ' . $exception->getMessage() . 'Please, try again';
            $this->lottery->resume();
        }
        
        // End of transaction
        
        return $won;
    }
}