<?php

namespace LobsterTest\Lottery\Interfaces;

use LobsterTest\Lottery\DTO\LotteryDTO;

interface LotteryDBInterface
{
    public function getLottery( string $id ): LotteryDTO|false;
    public function saveLottery( LotteryDTO $lottery ): bool;
    public function hasWinner( string $id, string $win_hash ): bool;
}