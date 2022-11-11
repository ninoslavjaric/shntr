#!/usr/local/bin/php

<?php
/**
 * @var $db mysqli
 */
require(__DIR__ . '/../bootstrap.php');

if (php_sapi_name() != 'cli') {
    redirect('/');
    exit(1);
}
$userQuery = $db->query('select user_id from users') or exit(1);
[, $host] = $argv;

if (!$host) {
    die("Enter host as a parameter\n");
}

$_SERVER['SERVER_NAME'] = $host;



echo '--------------------------------------------------' . PHP_EOL;
try {
//    $result = shntrToken::syncTransactions(0);

//    if (array_key_exists('callback', $result) && is_callable($result['callback'])) {
//        echo "Callingback for treasury\n";
//        $result['callback']();
//        echo "Calledback for treasury\n";
//    }

    $result = shntrToken::getRelysiaBalance(null, true);
    shntrToken::sync(0);
    echo "Refreshed balance for treasury" . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
echo '--------------------------------------------------' . PHP_EOL;


while ([$userId] = $userQuery->fetch_row()) {
    echo '--------------------------------------------------' . PHP_EOL;
    try {
//        $result = shntrToken::syncTransactions($userId);

//        if (array_key_exists('callback', $result) && is_callable($result['callback'])) {
//            echo "Callingback for {$userId}\n";
//            $result['callback']();
//            echo "Calledback for {$userId}\n";
//        }

        $result = shntrToken::getRelysiaBalance($userId, true);
        shntrToken::sync($userId);
        echo "Refreshed balance for {$userId}" . PHP_EOL;
    } catch (Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
    echo '--------------------------------------------------' . PHP_EOL;
}
