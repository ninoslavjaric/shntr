<?php
$cmd = 'cat error.log';

if ($_GET['query'] ?? false) {
    $cmd .= " | grep '{$_GET['query']}'";
}
$rows = $_GET['rows'] ?? 30;

$cmd .= " | tail -n '{$rows}'";

exec($cmd, $error_logs);

foreach($error_logs as $error_log) {

    echo '<br />' . $error_log;
}
