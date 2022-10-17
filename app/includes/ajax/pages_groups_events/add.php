<?php

/**
 * ajax -> pages_groups_events -> add
 *
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// user access
user_access(true);

// check demo account
if ($user->_data['user_demo']) {
	modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

try {

	// initialize the return array
	$return = array();

	switch ($_REQUEST['type']) {
		case 'page':
            $smarty->assign('interests', $user->get_page_interests(0));
			$query = $db->query("SELECT price FROM prices WHERE price_name = 'page_price';");
			$price = $query->fetch_assoc();
            $smarty->assign('price', $price['price']);
			// get custom fields
			$smarty->assign('custom_fields', $user->get_custom_fields(array("for" => "page")));

			// get pages categories
			$smarty->assign('categories', $user->get_categories("pages_categories"));

			// return
			$return['template'] = $smarty->fetch("ajax.page.publisher.tpl");
			$return['callback'] = "$('#modal').modal('show'); $('.modal-content:last').html(response.template); initialize_modal();";
			break;

		case 'group':
            $smarty->assign('interests', $user->get_group_interests(0));
			$query = $db->query("SELECT price FROM prices WHERE price_name = 'group_price';");
			$price = $query->fetch_assoc();
            $smarty->assign('price', $price['price']);
			// get custom fields
			$smarty->assign('custom_fields', $user->get_custom_fields(array("for" => "group")));

			// get groups categories
			$smarty->assign('categories', $user->get_categories("groups_categories"));

			// return
			$return['template'] = $smarty->fetch("ajax.group.publisher.tpl");
			$return['callback'] = "$('#modal').modal('show'); $('.modal-content:last').html(response.template); initialize_modal();";
			break;

		case 'event':
		    $smarty->assign('interests', $user->get_event_interests(0));
			$query = $db->query("SELECT price FROM prices WHERE price_name = 'event_price';");
			$price = $query->fetch_assoc();
		    $smarty->assign('price', $price['price']);
			// get custom fields
			$smarty->assign('custom_fields', $user->get_custom_fields(array("for" => "event")));

			// get events categories
			$smarty->assign('categories', $user->get_categories("events_categories"));

			// return
			$return['template'] = $smarty->fetch("ajax.event.publisher.tpl");
			$return['callback'] = "$('#modal').modal('show'); $('.modal-content:last').html(response.template); initialize_modal();";
			break;

		default:
			_error(400);
			break;
	}

	// return & exit
	return_json($return);
} catch (Exception $e) {
	modal("ERROR", __("Error"), $e->getMessage());
}
