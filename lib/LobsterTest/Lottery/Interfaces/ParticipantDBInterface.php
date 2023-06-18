<?php

namespace LobsterTest\Lottery\Interfaces;

use LobsterTest\Lottery\DTO\ParticipantDTO;

interface ParticipantDBInterface
{
    public function getParticipant( $ip, $lottery_id ): ParticipantDTO|false;
    public function saveParticipant( ParticipantDTO $participant ): bool;
}