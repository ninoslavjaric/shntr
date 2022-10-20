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
    modal('LOGIN');
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
            $paywallTransaction = $user->breach_paywall($_POST['paywallAuthorId']);

            if ($paywallTransaction) {
                blueModal("SUCCESS", __("Success"), __("A paywall is successfully unlocked!"), ["paywall-id" => $paywallTransaction]);
            }

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
