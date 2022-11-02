<?php
/**
 * @var $smarty Smarty_Internal_Data
 * @var $user User
 * @var $db mysqli
 */
// fetch bootloader

require('bootloader.php');

if (!$system['creditcard_enabled'] && !$system['alipay_enabled']) {
    blueModal("MESSAGE", __("Error"), __("This feature has been disabled by the admin"));
}


try {
    // get view content
    switch ($_GET['view']) {
        case '':

            break;

        case 'checkout':
            user_access();

            require_once(ABSPATH . 'includes/libs/Stripe/init.php');
            if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
                _error(404);
            }

            $secret_key = ($system['stripe_mode'] == "live") ? $system['stripe_live_secret'] : $system['stripe_test_secret'];
            \Stripe\Stripe::setApiKey($secret_key);
            $token = sha1($_COOKIE['PHPSESSID']);
            $qty = $_POST['qty'] ?? 5;

            /** @var \Stripe\Checkout\Session $checkout_session */
            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    'price' => 'price_1LmnCgJoiLHsoH4fYQZKP71j',
                    'quantity' => $qty,
                ]],
                'mode' => 'payment',
                'success_url' => SYS_URL . '/settings/shntr_token?purchase=success&amount=' . $qty,
                'cancel_url' => SYS_URL . '/settings/shntr_token?purchase=fail',
            ]);

            if (!$checkout_session->id){
                _error(404, 'No session id');
            }

            $db->query(
                sprintf("INSERT INTO stripe_transactions (session_id, user_id, qty) VALUES (%s, %s, %s)",
                    secure($checkout_session->id),
                    secure($user->_data['user_id'], 'int'),
                    secure($qty)
                )
            );
            error_log("debug stripe insert " . sprintf("INSERT INTO stripe_transactions (session_id, user_id, qty) VALUES (%s, %s, %s)",
                    secure($checkout_session->id),
                    secure($user->_data['user_id'], 'int'),
                    secure($qty)
                ));

            $secured = get_system_protocol() == 'https';
            $expire = time() + 60;
            setcookie('stripe_checkout', sha1($token), $expire, '/', '', $secured, true);
            setcookie('stripe_checkout_qty', $qty, $expire, '/', '', $secured, true);


            header("HTTP/1.1 303 See Other");
            header("Location: " . $checkout_session->url);

            break;

        case 'webhook':
            require_once(ABSPATH . 'includes/libs/Stripe/init.php');

            $endpoint_secret = getenv('STRIPE_WEBHOOK_SECRET') ?? 'whsec_Rnqisjn8dexS96xoik089znWpeQn5b79';

            $payload = @file_get_contents('php://input');
            if (!($sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null)) {
                error_log('No signature');
                http_response_code(404);
                return_json([
                    'success' => false,
                    'msg' => "No signature",
                ]);
            }
            $event = null;
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
                );
            } catch (\UnexpectedValueException $e) {
                error_log('UnexpectedValueException ' . $e->getMessage());

                http_response_code(400);
                return_json([
                    'success' => false,
                    'msg' => $e->getMessage(),
                ]);
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                error_log('SignatureVerificationException ' . $e->getMessage());
                http_response_code(400);
                return_json([
                    'success' => false,
                    'msg' => $e->getMessage(),
                ]);
            }

            if (!str_starts_with($event->type, 'checkout.session')) {
                error_log("Wrong event type ->> {$event->type}");
                http_response_code(400);
                return_json([
                    'success' => false,
                    'msg' => "Wrong event type ->> {$event->type}",
                ]);
            }
            /** @var \Stripe\Checkout\Session $checkout_session */
            $checkout_session = $event->data->object;

            $successUrlParsed = parse_url($checkout_session->success_url);
            if ("{$successUrlParsed['scheme']}://{$successUrlParsed['host']}" !== SYS_URL) {
                error_log("Wrong url {$successUrlParsed['scheme']}://{$successUrlParsed['host']}");
                http_response_code(400);
                return_json([
                    'success' => false,
                    'msg' => "Wrong url {$successUrlParsed['scheme']}://{$successUrlParsed['host']}",
                ]);
            }

            switch ($event->type) {
                case 'checkout.session.expired':
                case 'checkout.session.async_payment_failed':
                    $db->query(
                        sprintf(
                            'update stripe_transactions set status = "FAILED" where session_id = %s',
                            secure($checkout_session->id)
                        )
                    );
                    $errorMsg = $event->toJSON();
                    _email(
                        'admin@shntr.com', 'Stripe transaction expired or failed', $errorMsg, $errorMsg
                    );

                    return_json([
                        'success' => true,
                        'msg' => 'failed payment',
                    ]);
                    break;

                case 'checkout.session.completed':
                case 'checkout.session.async_payment_succeeded':

                    $transaction = $db->query(
                        sprintf(
                            'select 
                                           st.session_id, st.user_id, st.qty, u.user_relysia_paymail, u.user_email, st.status
                                    from stripe_transactions st 
                                        inner join users u using(user_id) 
                                    where st.session_id = %s',
                            secure($checkout_session->id)
                        )
                    )->fetch_assoc();

                    if ($transaction === null) {
                        $errorMsg = "No transaction {$checkout_session->id} in db";
                        _email('admin@shntr.com', 'Stripe transaction fail', $errorMsg, $errorMsg);
                        return_json([
                            'success' => false,
                            'msg' => $errorMsg,
                        ]);
                    }

                    if ($transaction['status'] !== 'PENDING') {
                        $errorMsg = "Transaction is not pending. {$checkout_session->id} is {$transaction['status']}";
                        _email('admin@shntr.com', 'Stripe transaction fail', $errorMsg, $errorMsg);
                        return_json([
                            'success' => false,
                            'msg' => $errorMsg,
                        ]);
                    }

                    $response = shntrToken::payRelysia(
                        $transaction['qty'],
                        $transaction['user_relysia_paymail'],
                        0
                    );

                    error_log('debug stripe relysia ' . json_encode([$response, $transaction]));
                    if (!str_contains($response['message'], 'sent successfully')) {
                        $cancellation = $checkout_session->payment_intent->cancel();
                        _email(
                            'admin@shntr.com',
                            'Token transaction fail | stripe',
                            $response['message'],
                            $response['message']
                        );

                        _email(
                            $transaction['user_email'],
                            'Token transaction fail | stripe',
                            $response['message'],
                            $response['message']
                        );

                        http_response_code(400);
                        return_json([
                            'success' => false,
                            'msg' => $response['message'],
                        ]);
                    }

                    shntrToken::noteTransaction(
                        $transaction['qty'],
                        0,
                        $transaction['user_id'],
                        null,
                        null,
                        'Buying shntr token'
                    );

                    $db->query(
                        sprintf(
                            'update stripe_transactions set status = "SUCCEEDED" where session_id = %s',
                            secure($checkout_session->id)
                        )
                    );

                    return_json([
                        'success' => true,
                        'msg' => 'ok',
                    ]);

                    break;

                default:
                    http_response_code(404);
                    return_json([
                        'success' => false,
                        'msg' => 'bad request',
                    ]);
            }

            break;

        default:
            _error(404);
    }
} catch (Exception $e) {
    _error(__("Error"), $e->getMessage());
}

/* assign variables */
$smarty->assign('view', $_GET['view']);

page_footer("stripe");
