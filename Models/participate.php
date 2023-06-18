<?php

    use LobsterTest\DB\DB;

    $lotteries_data_handler = new \LobsterTest\Lottery\LotteriesData(
        new \LobsterTest\DB\Gateways\DBLotteriesData(
            DB::get()
        )
    );
    
    $current_lotteries = $lotteries_data_handler->getCurrentLotteries();
    
    if( ! empty( $current_lotteries ) ){
        $lottery_id = $current_lotteries[0]['id'];
        
        $lottery = new \LobsterTest\Lottery\Lottery(
            new LobsterTest\DB\Gateways\DBGatewayLottery(
                DB::get()
            ),
            $lottery_id
        );
        
        $participant            = new \LobsterTest\Lottery\Participant(
            new LobsterTest\DB\Gateways\DBGatewayParticipant(
                DB::get()
            ),
            $lottery,
            LobsterTest\Visitor\IP::get()
        );
        
        $allowed_to_participate = $participant->allowedToRoll();
        
    
        $script = "<script>
            jQuery('.button__participate').on('click', function(event){
                let button = jQuery(event.target);
                ajax('participate', {lottery_id: button.attr('lottery_id')}, function( result ){
                    if( result.won === true ){
                        alert( 'Вы выйграли!!! Контактных данных не надо, вас вычислят по IP...' );
                    }else{
                        alert( 'Не переживайте, в слeдующий раз повезет...' );
                    }
                    button.attr('disabled', true);
                });
            });
        </script>";
        
        require_once 'Views\visitor.php';
    }else{
        require_once 'Views\no_lotteries.php';
    }
