<?php

namespace LobsterTest\Lottery\Interfaces;

interface LotteriesDataDBInterface
{
    public function getLotteriesData(): array;
    public function getParticipantsData(): array;
}