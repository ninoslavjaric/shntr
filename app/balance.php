<?php
/**
 * @var $smarty Smarty_Internal_Data
 * @var $user User
 * @var $db mysqli
 */

require(__DIR__ . '/bootstrap.php');

//trigger_error(var_dump(shntrToken::auth('relysia@shntr.com', 'Jg3KDB9G13SbKGZML39tGg==')));


    if (isset($_GET['user_id'])) {
        $response = shntrToken::getRelysiaApiBalance($_GET['user_id']);

        var_dump($response);
        die();
    }


