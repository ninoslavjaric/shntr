<?php

$commands = array_map(
    fn($item) => $_GET['query'] ?? false ? "zgrep -i '{$_GET['query']}' {$item}" : "zcat {$item}",
    glob(__DIR__ . '/error.*.log.gz')
);

$current = __DIR__ . '/error.log';
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

$output = implode(PHP_EOL, $logs);

echo "<pre>{$output}</pre>";
