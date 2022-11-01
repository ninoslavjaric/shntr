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
while ([$userId] = $userQuery->fetch_row()) {
    echo '--------------------------------------------------' . PHP_EOL;
    try {
        $result = shntrToken::syncTransactions($userId, true);

        if (array_key_exists('callback', $result) && is_callable($result['callback'])) {
            echo "Callingback for {$userId}\n";
            $result['callback']();
            echo "Calledback for {$userId}\n";
        }
    } catch (Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
    echo '--------------------------------------------------' . PHP_EOL;
}
