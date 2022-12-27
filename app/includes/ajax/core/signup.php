<?php

/**
 * ajax -> core -> signup
 *
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// check user logged in
if ($user->_logged_in) {
	return_json(array('callback' => 'window.location.reload();'));
}

// check if registration is open
if (!$system['registration_enabled']) {
	return_json(array('error' => true, 'message' => __('Registration is closed right now')));
}

// check honeypot
if (!is_empty($_POST['field1'])) {
	return_json();
}

try {

	// signup
	$user->sign_up($_POST);
    webmail_register($_POST['username']);
	global $db, $system;
//	/* generate email verification code */
//	$email_verification_code = get_hash_token();
//	/* update user */
//	$db->query(sprintf("UPDATE users SET user_email_verification_code = %s WHERE user_name = %s", secure($email_verification_code), secure($_POST['username']))) or _error("SQL_ERROR_THROWEN");
//	/* prepare activation email */
//	$subject = __("Just one more step to get started on") . " " . $system['system_title'];
//	$body = get_email_template("activation_email", $subject, ["name" => $_POST['username'], "email_verification_code" => $email_verification_code]);
//	/* send email */
//	if (!_email($_POST['email'], $subject, $body['html'], $body['plain'])) {
//		throw new Exception(__("Activation email could not be sent"));
//	}

	// return
	return_json(array('callback' => 'window.location.reload();'));
} catch (Exception $e) {
	return_json(array('error' => true, 'message' => $e->getMessage()));
}
