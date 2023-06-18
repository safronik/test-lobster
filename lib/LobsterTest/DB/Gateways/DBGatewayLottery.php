<?php

namespace LobsterTest\DB\Gateways;

use LobsterTest\Lottery\DTO\LotteryDTO;
use LobsterTest\Lottery\Interfaces\LotteryDBInterface;

class DBGatewayLottery extends DBGateway implements LotteryDBInterface
{
    public function getLottery( $id ): LotteryDTO|false
    {
        $select_result = $this->db->select( "SELECT id,start_time,win_chance,win_hash,duration,lottery_status,restart_times FROM lotteries WHERE id='$id'")[0] ?? null;
        
        return $select_result
            ? new LotteryDTO( $select_result ):
            false;
    }
    
    public function saveLottery( LotteryDTO $lottery ): bool
    {
        try{
            return $this->db->insert( "
                INSERT INTO lotteries
                    (id,start_time,win_chance,win_hash,duration,lottery_status,restart_times)
                    VALUES (
                        '$lottery->id',
                        '$lottery->start_time',
                        '$lottery->win_chance',
                        '$lottery->win_hash',
                        '$lottery->duration',
                        '$lottery->lottery_status',
                         $lottery->restart_times
                    );
            ");
        }catch( \Exception $exception ){
            if( $exception->getCode() === '23000' ){
                return $this->db->update( "
                    UPDATE lotteries
                        SET
                            start_time = '$lottery->start_time',
                            win_chance = '$lottery->win_chance',
                            win_hash = '$lottery->win_hash',
                            duration = '$lottery->duration',
                            lottery_status = '$lottery->lottery_status',
                            restart_times = '$lottery->restart_times'
                        WHERE
                            id='$lottery->id'
                ");
            }
        }
        
        return false;
    }
    
    public function hasWinner( string $id, string $win_hash ): bool
    {
        return (bool) $this->db->select( "SELECT p.hash FROM participants AS p WHERE p.hash = (SELECT l.win_hash FROM lotteries AS l WHERE id = '$id')");
    }
}