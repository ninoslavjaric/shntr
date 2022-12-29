<?php

define('DIRECTOR', dirname(ini_get('error_log')));

$commands = array_map(
    fn($item) => $_GET['query'] ?? false ? "zgrep -i '{$_GET['query']}' {$item}" : "zcat {$item}",
    glob(DIRECTOR . '/error.*.log.gz')
);

$current = DIRECTOR. '/error.log';
$commands[] = ($_GET['query'] ?? false ? "grep -i '{$_GET['query']}' " : "cat ") . $current;


$rows = $_GET['rows'] ?? 30;
$logs = [];
while ($rows > 0 && $cmd = array_pop($commands)) {
    $cmd .= " | tail -{$rows}";
    $error_logs = [];
    exec($cmd, $error_logs);
    $rows -= count($error_logs);
    $logs = array_merge($logs, $error_logs);
}

foreach($logs as &$log) {
        $log = json_decode($log, 1) ?: $log;
}


header('content-type: application/json');
echo json_encode($logs);
