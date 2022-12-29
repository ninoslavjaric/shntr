<?php

/**
 * ajax -> users -> paywall
 *
 * @package Sngine
 * @author Sasa
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// user access
user_access(true);

// check user logged in
if (!$user->_logged_in) {
    blueModalImproved(["modalId" => "LOGIN"]);
}

try {

    // initialize the return array
    $return = array();

    switch ($_POST['do']) {
        case 'pay':
            // valid inputs
            if (!isset($_POST['paywallAuthorId']) || !is_numeric($_POST['paywallAuthorId'])) {
                blueModal("ERROR", __("Error"), __("There is something that went wrong!"));
            }

            // paywall pay process
            $time_start = microtime(true);
            $paywallTransaction = $user->breach_paywall((int) $_POST['paywallAuthorId']);
            $time_end = microtime(true);
            $execution_time = $time_end - $time_start;
            $errorBody = [
                'message' => 'breach_paywall execution time',
                'execution time' => $execution_time,
            ];
            trigger_error(json_encode($errorBody));

            if ($paywallTransaction) {
                blueModal("SUCCESS", __("Success"), __("A paywall is successfully unlocked!"), ["paywall-id" => $paywallTransaction]);
            }

            trigger_error(json_encode(['breach_paywall' => $paywallTransaction]));

            blueModal("ERROR", __("Error"), __("There is something that went wrong!"));
            break;

        default:
            blueModal("ERROR", __("Error"), __("There is something that went wrong!"));
            break;
    }

    // return & exit
    return_json($return);
} catch (Exception $e) {
    blueModal("ERROR", __("Error"), $e->getMessage());
}
