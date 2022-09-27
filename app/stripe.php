<?php
/**
 * @var $smarty Smarty_Internal_Data
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

            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    'price' => 'price_1LmnCgJoiLHsoH4fYQZKP71j',
                    'quantity' => $_POST['qty'] ?? 5,
                ]],
                'mode' => 'payment',
                'success_url' => SYS_URL . '/buy-tokens/success',
                'cancel_url' => SYS_URL . '/buy-tokens/fail',
            ]);

            $secured = get_system_protocol() == 'https';
            $expire = time() + 60;
            setcookie('stripe_checkout', 1, $expire, '/', '', $secured, true);

            redirect($checkout_session->url, '');
            break;

        case 'success':
        case 'fail':
            if (!isset($_COOKIE['stripe_checkout'])) {
                _error(403);
            }

            $secured = get_system_protocol() == 'https';
            setcookie('stripe_checkout', 1, time(), '/', '', $secured, true);
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
