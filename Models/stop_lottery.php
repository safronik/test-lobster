<?php

    use LobsterTest\Variables\Get;
    use LobsterTest\DB\DB;
    
    $lottery = new \LobsterTest\Lottery\Lottery(
        new LobsterTest\DB\Gateways\DBGatewayLottery(
            DB::get()
        ),
        Get::get( 'lottery_id', STR )
    );
    
    $ajax_response = [ 'stopped' => $lottery->stop() ];
    
    require_once 'Views\AJAX.php';