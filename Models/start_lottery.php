<?php

    use LobsterTest\Variables\Get;
    use LobsterTest\DB\DB;
    
    $lottery = new \LobsterTest\Lottery\Lottery(
        new LobsterTest\DB\Gateways\DBGatewayLottery(
            DB::get()
        )
    );
    
    $lottery_params = [];
    Get::get( 'win_chance', FLOAT )       && $lottery_params['win_chance']         = Get::get( 'win_chance', FLOAT );
    Get::get( 'duration', INT )           && $lottery_params['duration']           = Get::get( 'duration', INT );
    Get::get( 'lottery_start_time', INT ) && $lottery_params['lottery_start_time'] = Get::get( 'lottery_start_time', INT );
    Get::get( 'restart_times', INT )      && $lottery_params['restart_times']      = Get::get( 'restart_times', INT );
    
    $ajax_response = [ 'started' => $lottery->startLottery( ...$lottery_params ) ];
    
    require_once 'Views\AJAX.php';