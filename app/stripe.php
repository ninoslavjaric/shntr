<?php
/**
 * @var $smarty Smarty_Internal_Data
 * @var $user User
 * @var $db mysqli
 */
// fetch bootloader
require('bootloader.php');
// user access
user_access();

if (!$system['creditcard_enabled'] && !$system['alipay_enabled']) {
    modal("MESSAGE", __("Error"), __("This feature has been disabled by the admin"));
}


try {
    // get view content
    switch ($_GET['view']) {
        case '':

            break;

        case 'checkout':
            require_once(ABSPATH . 'includes/libs/Stripe/init.php');
            if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
                _error(404);
            }

            $secret_key = ($system['stripe_mode'] == "live") ? $system['stripe_live_secret'] : $system['stripe_test_secret'];
            \Stripe\Stripe::setApiKey($secret_key);
            $token = sha1($_COOKIE['PHPSESSID']);
            $qty = $_POST['qty'] ?? 5;

            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    'price' => 'price_1LmnCgJoiLHsoH4fYQZKP71j',
                    'quantity' => $qty,
                ]],
                'mode' => 'payment',
                'success_url' => SYS_URL . '/buy-tokens/success?token=' . $token,
                'cancel_url' => SYS_URL . '/buy-tokens/fail?token=' . $token,
            ]);

            $secured = get_system_protocol() == 'https';
            $expire = time() + 60;
            setcookie('stripe_checkout', sha1($token), $expire, '/', '', $secured, true);
            setcookie('stripe_checkout_qty', $qty, $expire, '/', '', $secured, true);

            redirect($checkout_session->url, '');
            break;

        case 'success':
        case 'fail':
            $secured = get_system_protocol() == 'https';

            if (
                !isset($_COOKIE['stripe_checkout'], $_COOKIE['stripe_checkout_qty'], $_GET['token'])
                || count(
                    array_unique([sha1(sha1($_COOKIE['PHPSESSID'])), sha1($_GET['token']), $_COOKIE['stripe_checkout']])
                ) !== 1
            ) {
                setcookie('stripe_checkout', 0, time(), '/', '', $secured, true);
                setcookie('stripe_checkout_qty', 0, time(), '/', '', $secured, true);
                redirect('/settings/shntr_token');
            }

            if ($_GET['view'] == 'success' && in_array($_SERVER['SERVER_NAME'], ['localhost', 'test.shntr.com'])) {
                $query = $db->query('select user_token_private_key from users where user_id = 1');
                $pkey = $query->fetch_row()[0];

                $response = shntrToken::pay(
                    $pkey, $user->_data['user_token_address'], $_COOKIE['stripe_checkout_qty']
                );

                if (!str_contains($response['message'], 'success')) {
                    _error(400, $response['message']);
                }

                shntrToken::noteTransaction(
                    $_COOKIE['stripe_checkout_qty'],
                    1,
                    $user->_data['user_id'],
                    null,
                    null,
                    'Buying shntr token'
                );
            }

            setcookie('stripe_checkout', 0, time(), '/', '', $secured, true);
            setcookie('stripe_checkout_qty', 0, time(), '/', '', $secured, true);

            break;

        default:
            _error(404);
            break;
    }
} catch (Exception $e) {
    _error(__("Error"), $e->getMessage());
}

/* assign variables */
$smarty->assign('view', $_GET['view']);

page_footer("stripe");
