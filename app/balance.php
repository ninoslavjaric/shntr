<?php
/**
 * @var $smarty Smarty_Internal_Data
 * @var $user User
 * @var $db mysqli
 */

require(__DIR__ . '/bootstrap.php');

//error_log(var_dump(shntrToken::auth('relysia@shntr.com', 'Jg3KDB9G13SbKGZML39tGg==')));


    if (isset($_GET['user_id'])) {
        $response = shntrToken::getRelysiaApiBalance($_GET['user_id']);

        var_dump($response);
        die();
    } else {
        error_log(var_dump('Add parameter like https://test.shntr.com/balance?user_id=1'));
    }


