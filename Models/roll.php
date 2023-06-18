<?php

    use LobsterTest\DB\DB;
    use LobsterTest\Variables\Get;
    use LobsterTest\Lottery\LotteryDrawing;
    
    $db = DB::get();
    
    // Participate
    $lottery     = new \LobsterTest\Lottery\Lottery(
        new LobsterTest\DB\Gateways\DBGatewayLottery( $db ),
        Get::get( 'lottery_id', STR )
    );
    
    $participant = new \LobsterTest\Lottery\Participant(
        new LobsterTest\DB\Gateways\DBGatewayParticipant( $db ),
        $lottery,
        LobsterTest\Visitor\IP::get()
    );
    
    $drawing       = new LotteryDrawing( $lottery, $participant );
    $won           = $drawing->roll();
    
    $ajax_response = [ 'won' => $won ];
    
    require_once 'Views\AJAX.php';
