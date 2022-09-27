<?php

/**
 * @var $db mysqli
 */
require(__DIR__ . '/../bootstrap.php');

$db->query('create or replace table users_bak like users');
$db->query('insert into users_bak select * from users');
$users = $db->query('select user_id id, user_token_private_key pk from users_bak')->fetch_all(MYSQLI_ASSOC);

foreach ($users as &$user) {
    $user['pk_encrypted'] = openssl_encrypt($user['pk'], 'bf-cbc', getenv('shntr_TOKEN_PASSPHRASE'));
    $db->query(sprintf('update users_bak set user_token_private_key = %s where user_id = %s', secure($user['pk_encrypted']), secure($user['id'], 'int', false)));
}

echo 'DONE';
