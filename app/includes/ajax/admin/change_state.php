<?php
/**
 * ajax -> admin -> delete
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

try {
    $id = $_POST['id'];
    $state = $_POST['state'];
    $db->query(sprintf("UPDATE info_sell_token SET state = '".$state."' WHERE id = '".$id."'")) or _error("SQL_ERROR_THROWEN");
} catch (Exception $e) {
	blueModal("ERROR", __("Error"), $e->getMessage());
}
