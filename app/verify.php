<?php
/**
 * @var $smarty Smarty_Internal_Data
 * @var $user User
 * @var $db mysqli
 */

require(__DIR__ . '/bootstrap.php');

if (!TEST_ENVIRONMENT) {
    _error(404);
}
trigger_error(json_encode($_POST));

if (isset($_POST['username']) && isset($_POST['password'])) {

    $query = $db->query(sprintf("SELECT * FROM users WHERE user_name = %s", secure($_POST['username'])))
    or _error("SQL_ERROR_THROWEN", $db);

    $user = false;

    if ($query->num_rows > 0) {
            $user = $query->fetch_assoc();
    }

    if ($user && password_verify($_POST['password'], $user['user_password'])){
        shntrToken::noteTransaction(
            1000,
            0,
            $user['user_id'],
            null,
            null,
            'INIT',
            null,
            $user['user_relysia_paymail']);

        return_json( 200);
    } else {
        trigger_error('Check credentials');
        return_json( 401);
    }

} else {
    trigger_error('API verification failed');
    return_json( 400);
}


