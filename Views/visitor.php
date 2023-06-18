<?php

$page_title = $allowed_to_participate
    ? 'Лотырея! 100500 выйгрыш!'
    : 'Вы уже принимали участие в розыгрыше';

$title = 'Лотырея! 100500 выйгрыш!';

$content =
    '<header class="header">
        <h1 class="header__header-main --center">' . $page_title . '</h1>
    </header>';

$content .= $allowed_to_participate
    ? '<div class="content --center">
            <button class="button__participate" lottery_id="'. $lottery_id.'" ' . ( ! $allowed_to_participate ? 'disabled="true" ' : '' ) . '">Принять участие!</button>
        </div>
        <footer class="footer">
        
        </footer>'
    : '';

require_once 'Templates\page.php';