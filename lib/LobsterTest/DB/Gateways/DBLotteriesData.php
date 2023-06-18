<?php

namespace LobsterTest\DB\Gateways;

class DBLotteriesData extends DBGateway implements \LobsterTest\Lottery\Interfaces\LotteriesDataDBInterface
{
    public function getCurrentLotteries(): array
    {
        return $this->db->select('SELECT * FROM lotteries WHERE lottery_status = "IN_PROCESS" AND start_time < UNIX_TIMESTAMP()');
    }
    
    public function getLotteriesData(): array
    {
        return $this->db->select('SELECT * FROM lotteries');
    }
    
    public function getParticipantsData(): array
    {
        return $this->db->select('SELECT * FROM participants');
    }
}