<?php

namespace LobsterTest\DB\Gateways;

use LobsterTest\Lottery\DTO\ParticipantDTO;
use LobsterTest\Lottery\Interfaces\ParticipantDBInterface;

class DBGatewayParticipant extends DBGateway implements ParticipantDBInterface
{
    public function getParticipant( $ip, $lottery_id ): ParticipantDTO|false
    {
        $select_result =  $this->db->select( "
            SELECT * FROM participants
                WHERE
                    ip = '$ip' AND
                    lottery_id = '$lottery_id';"
        )[0] ?? [];
        
        return $select_result
            ? new ParticipantDTO($select_result)
            : false;
    }
    
    public function saveParticipant( ParticipantDTO $participant ): bool
    {
        return (bool) $this->db->insert("
            INSERT INTO participants
                (ip,lottery_id,hash,roll_time)
                VALUES (
                    '$participant->ip',
                    '$participant->lottery_id',
                    '$participant->hash',
                    $participant->roll_time
                )
                ON DUPLICATE KEY UPDATE
                    ip = '$participant->ip',
                    lottery_id = '$participant->lottery_id',
                    hash = '$participant->hash',
                    roll_time = $participant->roll_time
        ");
    }

}