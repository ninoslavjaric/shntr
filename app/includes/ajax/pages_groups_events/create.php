<?php

/**
 * ajax -> pages_groups_events -> create|edit
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
	blueModal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

// valid inputs
if (!in_array($_GET['do'], ['create', 'edit'])) {
	_error(400);
}

try {

	// initialize the return array
	$return = array();
	$return['callback'] = 'window.location.replace(response.path);';

	switch ($_GET['type']) {
		case 'page':
			if ($_GET['do'] == "create") {
				if (empty($user->_data['user_relysia_password'])) {
					$user->register_to_relysia(
						$user->_data['user_name'], $user->_data['user_id']
					);
				}

				$balance = shntrToken::getRelysiaBalance();

				$query = $db->query("SELECT price FROM prices WHERE price_name = 'page_price';");
				$price = $query->fetch_assoc();
		
				if ($balance < $price['price']) {
					blueModal("ERROR", __("Funds"), __("You're out of tokens"), null, true, true);
				}

				// page create
				$user->create_page($_POST);

				// return
				$return['path'] = $system['system_url'] . '/pages/' . $_POST['username'];
			} elseif ($_GET['do'] == "edit") {

				// valid inputs
				if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
					_error(400);
				}
				if (!in_array($_GET['edit'], array('settings', 'info', 'action', 'social', 'interests'))) {
					_error(400);
				}

				// page edit
				$page_name = $user->edit_page($_GET['id'], $_GET['edit'], $_POST);

				// return
				$return['path'] = $system['system_url'] . '/pages/' . $page_name;
			}
			break;

		case 'group':
			if ($_GET['do'] == "create") {
        if (empty($user->_data['user_relysia_password'])) {
            $user->register_to_relysia(
                $user->_data['user_name'], $user->_data['user_id']
            );
        }
        $balance = shntrToken::getRelysiaBalance();

				$query = $db->query("SELECT price FROM prices WHERE price_name = 'group_price';");
				$price = $query->fetch_assoc();
        if ($balance < $price['price']) {
            blueModal("ERROR", __("Funds"), __("You're out of tokens"));
        }

				// group create
				$group_id = $user->create_group($_POST);

                $user->edit_group_interests($_POST['interests'], $group_id);

				// return
				$return['path'] = $system['system_url'] . '/groups/' . $_POST['username'];
			} elseif ($_GET['do'] == "edit") {

				// valid inputs
				if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
					_error(400);
				}


                switch ($_GET['edit']) {
                    case 'interests':
                        /* check if interests enabled */
                        if (!$system['interests_enabled']) {
                            _error(404);
                        }

                        /* validate interests */
                        if (empty($_POST['interests']) || !valid_array_of_positive_ints($_POST['interests'])) {
                            throw new Exception(__("Please enter a valid array of interests"));
                        }

                        $user->edit_group_interests($_POST['interests'], $_GET['id']);

                        // return
                        $return['path'] = $_SERVER['HTTP_REFERER'];
                        break;
                    default:
                        // group edit
                        $user->edit_group($_GET['id'], $_POST);

                        // return
                        $return['path'] = $system['system_url'] . '/groups/' . $_POST['username'];
                }

			}
			break;

		case 'event':
			if ($_GET['do'] == "create") {
        if (empty($user->_data['user_relysia_password'])) {
            $user->register_to_relysia(
                $user->_data['user_name'], $user->_data['user_id']
            );
        }
        $balance = shntrToken::getRelysiaBalance();

				$query = $db->query("SELECT price FROM prices WHERE price_name = 'event_price';");
				$price = $query->fetch_assoc();
        if ($balance < $price['price']) {
            blueModal("ERROR", __("Funds"), __("You're out of tokens"));
        }

				// event create
				$event_id = $user->create_event($_POST);

                $user->edit_event_interests($_POST['interests'], $event_id);

				// return
				$return['path'] = $system['system_url'] . '/events/' . $event_id;
			} elseif ($_GET['do'] == "edit") {

				// valid inputs
				if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
					_error(400);
				}

				switch ($_GET['edit']) {
                    case 'interests':
                        /* check if interests enabled */
                        if (!$system['interests_enabled']) {
                            _error(404);
                        }

                        /* validate interests */
                        if (empty($_POST['interests']) || !valid_array_of_positive_ints($_POST['interests'])) {
                            throw new Exception(__("Please enter a valid array of interests"));
                        }

                        $user->edit_event_interests($_POST['interests'], $_GET['id']);
                        break;

                    default:
                        // event edit
                        $user->edit_event($_GET['id'], $_POST);
                }

				// return
				$return['path'] = $system['system_url'] . '/events/' . $_GET['id'];
			}
			break;

		default:
			_error(400);
			break;
	}

	// return & exit
	return_json($return);
} catch (Exception $e) {
	return_json(array('error' => true, 'message' => $e->getMessage()));
}
