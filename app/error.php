<?php
$cmd = 'cat error.log';

if ($_GET['query'] ?? false) {
    $cmd .= " | grep '{$_GET['query']}'";
}

$cmd .= ' | tail -n 30';

exec($cmd, $error_logs);

foreach($error_logs as $error_log) {

    echo '<br />' . $error_log;
}
