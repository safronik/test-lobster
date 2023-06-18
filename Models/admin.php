<?php

    $db = \LobsterTest\DB\DB::get();
    
    $lotteries_data_getter = new \LobsterTest\Lottery\LotteriesData(
        new \LobsterTest\DB\Gateways\DBLotteriesData(
            \LobsterTest\DB\DB::get()
        )
    );

    $lotteries_data    = $lotteries_data_getter->getAllLotteries();
    $participants_data = $lotteries_data_getter->getAllParticipants();
    
    $form = [];
    $form['title'] = 'Новая лотырея';
    $form['fields'] = \LobsterTest\Lottery\DTO\LotteryDTO::getFields( true );
    $form['action'] = 'ajax/start_lottery';
    $form['submit'] = 'Создать лотырею';
    
    $lottery_form = require 'Views\Templates\form.php'; // Just for presentation. Code inappropriate.

    $script = "<script>
        jQuery('.form').on('submit', function(event){
            event.preventDefault();
            ajax('start_lottery?' + jQuery('.form').serialize(), {}, function( result ){
                if( result.started === true ){
                    alert( 'Лотырея создана' );
                }
                location.reload();
            });
        });

    </script>";

    require_once 'Views\admin.php';