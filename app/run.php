<?php
/**
 * @var $db mysqli
 */
require('bootloader.php');

//if ($_SERVER['HTTP_HOST'] !== 'apache-shntr' && $_SERVER['REMOTE_ADDR'] !== gethostbyname('coin-svc')) {
//http_response_code(403);
//    _error(403);
//}
if (!isset($_GET['key'])) {
    http_response_code(404);
    _error(404);
}

$key = base64_decode($_GET['key']);

switch ($_GET['handle']) {
    case 'get':
        $block = $db->query(sprintf('select * from `run_blocks` where `hash` = %s', secure($key)))->fetch_assoc();
        break;

    case 'set':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['key'])) {
            http_response_code(404);
            _error(404);
        }
        $value = base64_encode(file_get_contents('php://input'));
        $db->query(
            sprintf(
                'insert ignore into `run_blocks` (`hash`, `value`) values (%s, %s)',
                secure($key), secure($value)
            )
        );

        $block = $db->query(sprintf('select * from `run_blocks` where `hash` = %s', secure($key)))->fetch_assoc();
        break;

    default:
        http_response_code(404);
        _error(404);
}

if (!$block) {
    http_response_code(404);
    _error(404, 'no record');
}

$block['value'] = base64_decode($block['value']);
//$block['value'] = json_decode($block['value'], 1) ?? $block['value'];

return_json($block);
