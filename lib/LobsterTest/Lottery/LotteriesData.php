<?php

namespace LobsterTest\Lottery;

use LobsterTest\Lottery\Interfaces\LotteriesDataDBInterface;

class LotteriesData
{
    private LotteriesDataDBInterface $gateway;
    
    public function __construct( LotteriesDataDBInterface $gateway )
    {
        $this->gateway = $gateway;
    }
    
    public function getCurrentLotteries(): array
    {
        return $this->gateway->getCurrentLotteries();
    }
    
    public function getAllLotteries(): array
    {
        return $this->gateway->getLotteriesData();
    }
    
    public function getAllParticipants(): array
    {
        return $this->gateway->getParticipantsData();
    }

}