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
		$query = $db->query(sprintf('SELECT user_id from users WHERE user_email_verification_code = %s;', secure($_GET['code']))) or _error("SQL_ERROR_THROWEN");
		$loginInfo = $query->fetch_row()[0];
		$db->query(sprintf("UPDATE users SET user_email_verified = '1' WHERE user_id = %s;", secure($loginInfo))) or _error("SQL_ERROR_THROWEN");
	}
	redirect();
} catch (Exception $e) {
	_error(__("Error"), $e->getMessage());
}
