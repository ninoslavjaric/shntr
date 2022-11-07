<?php

/**
 * activation
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap
require('bootstrap.php');

// valid inputs
if (!isset($_GET['code'])) {
	_error(404);
}

// user access
// if (!$user->_logged_in) {
// 	user_login();
// }

try {

	// activation
	if ($user->_logged_id) {
		$user->activation_email($_GET['code']);
	}else {
		global $db, $system;
		$query = $db->query(sprintf('SELECT user_id, user_activated, user_referrer_id, user_email_verified, user_email_verification_code from users WHERE user_email_verification_code = %s', secure($_GET['code']))) or _error("SQL_ERROR_THROWEN");
		$loginInfo = $query->fetch_assoc();
        /* check user */
        if ($loginInfo['user_email_verified']) {
            /* user email already verified => redirect */
            redirect();
        }
        if ($loginInfo['user_email_verification_code'] != $_GET['code']) {
            /* wrong verification code => 404 */
            _error(404);
        }
        /* check if user [1] activate his account & verify his email or [2] just verify his email */
        if ($system['activation_enabled'] && $system['activation_type'] == "email" && !$loginInfo['user_activated']) {
            /* [1] activate his account & verify his email */
            $db->query(sprintf("UPDATE users SET user_activated = '1', user_email_verified = '1' WHERE user_id = %s", secure($loginInfo['user_id'], 'int'))) or _error("SQL_ERROR_THROWEN");
            /* affiliates system */
            $this->process_affiliates("registration", $loginInfo['user_id'], $loginInfo['user_referrer_id']);

            // get user paymail and send tokens
            $query = $db->query(sprintf('select user_relysia_paymail as address from users where user_id = %1$s limit 1', secure($loginInfo['user_id'], 'int'))) or _error("SQL_ERROR_THROWEN");
            $recipientAddress = $query->fetch_row()[0];

            shntrToken::payRelysia(1000, $recipientAddress, 0);
            shntrToken::noteTransaction(1000, 0, $loginInfo['user_id'], null, null, 'INIT');
        } else {
            /* [2] just verify his email */
            $db->query(sprintf("UPDATE users SET user_email_verified = '1' WHERE user_id = %s", secure($loginInfo['user_id'], 'int'))) or _error("SQL_ERROR_THROWEN");

            // get user paymail and send tokens
            $query = $db->query(sprintf('select user_relysia_paymail as address from users where user_id = %1$s limit 1', secure($loginInfo['user_id'], 'int'))) or _error("SQL_ERROR_THROWEN");
            $recipientAddress = $query->fetch_row()[0];

            shntrToken::payRelysia(1000, $recipientAddress, 0);
            shntrToken::noteTransaction(1000, 0, $loginInfo['user_id'], null, null, 'INIT');
        }
	}
	redirect();
} catch (Exception $e) {
	_error(__("Error"), $e->getMessage());
}
