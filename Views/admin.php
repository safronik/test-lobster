<?php
    
    if( empty( $lotteries_data ) ){
        $lottery_table = 'Нет данных';
    }else{
        $lottery_table = '<table class="table-lotteries">';
        $lottery_table .= '<tr><td>' . implode( '</td><td>', array_keys( current($lotteries_data) ) ). '</tr></td>';
        foreach( $lotteries_data as &$lottery_datum ){
            $lottery_datum = '<td>' . implode( '</td><td>', $lottery_datum) . '</td>';
        }
        $lottery_table .= '<tr>' . implode( '</tr><tr>', $lotteries_data) . '</tr>';
        $lottery_table .= '</table>';
    }
    
    $title = 'Управление лотыреями';
    $content =
        '<header class="header">
            <h1 class="header__header-main">Управление лотыреями</h1>
        </header>'
        . $lottery_form
        . '<div class="content content-admin_table --inline-block">
            <h2 class="--center">Лотыреи</h2>'
                . $lottery_table
        . '</div>
        <footer class="footer">
        
        </footer>';
    
    require_once 'Templates\page.php';