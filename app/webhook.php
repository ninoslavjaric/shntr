<?php

$endpoint_secret = 'whsec_3083dbd6546864fa7749b5e76c27a3b2170225fa27c3398b1430091f7e3eccfa'; //TODO: move to .env

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

//require('bootloader.php');

//require_once(ABSPATH . 'includes/libs/Stripe/init.php');
require_once (__DIR__ . '/includes/libs/Stripe/init.php');

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    error_log('Invalid payload ' . $e);
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    error_log('Invalid signature ' . $e);
    http_response_code(400);
    exit();
}

// Handle the event
switch ($event->type) {
    case 'checkout.session.completed':
        $session = $event->data->object;

        // Payment confirmed we can send tokens

        //TODO: find checkout by session_id set status paid - or delete after

//        $query = $db->query("select session_id, user_id, qty from stripe_transactions where session_id = $session->id")
//            ->fetch_assoc();

//        $query = $db->query('select user_token_private_key from users where user_id = 1');
//        $pkey = $query->fetch_row()[0];

        $response = shntrToken::payRelysia(//TODO: here
            0,//qty
            'mail', //recipientPaymail
            0//sender id
        );

        if (!str_contains($response['message'], 'sent successfully')) {
            _error(400, $response['message']);
        }

        shntrToken::noteTransaction(//TODO: here
            5,//qty
            1,//sender id
            'mail',//recipient paymail
            null,
            null,
            'Buying shntr token'
        );
        break;

    default:
        error_log('Received unknown event type ' . $event->type);
}

http_response_code(200);
