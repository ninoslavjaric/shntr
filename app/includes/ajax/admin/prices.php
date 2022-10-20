<?php

/**
 * ajax -> admin -> genders
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// check admin|moderator permission
if (!$user->_is_admin) {
	blueModal("MESSAGE", __("System Message"), __("You don't have the right permission to access this"));
}

// check demo account
if ($user->_data['user_demo']) {
	blueModal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

// handle genders
try {
	switch ($_GET['edit']) {
		case 'manage_prices':
			/* update */
			update_prices([
				'page_price' => secure($_POST['page_price']),
				'product_price' => secure($_POST['product_price']),
				'event_price' => secure($_POST['event_price']),
				'group_price' => secure($_POST['group_price']),
				'send_fr_price' => secure($_POST['send_fr_price']),
				'accept_fr_price' => secure($_POST['accept_fr_price'])
			]);
			/* return */
			return_json(array('success' => true, 'message' => __("Prices have been updated")));
			break;

		default:
			_error(400);
			break;
	}
} catch (Exception $e) {
return_json(array('error' => true, 'message' => /*$e->getMessage()*/ $string));
}
