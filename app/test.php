<?php

/**
 * ads
 *
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');
require_once(ABSPATH . 'includes/libs/AWS/aws-autoloader.php');


$awsClient = Aws\Sqs\SqsClient::factory([
    'version'    => 'latest',
    'region'      => 'us-east-1',
    'endpoint' => 'http://localstack-shntr:4566',
//    'credentials' => [
//        'key'    => 'dummy',
//        'secret' => 'dummy',
//    ],
]);

$awsClient->sendMessage([
    'QueueUrl' => 'http://localstack-shntr:4566/000000000000/test',
    'MessageBody' => json_encode([
        'userId' => 5,
        'data' => [
            'djes' => 'aaaa',
            'time' => time(),
        ]
    ]),
]);

