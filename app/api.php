<?php

/**
 * api
 *
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap|bootloader
if ($_GET['do'] == "oauth") {
	require('bootloader.php');
} else {
	require('bootstrap.php');
}

try {

	// initialize the return array
	$return = array();

	switch ($_GET['do']) {
		case 'oauth':
			// user access
			user_access();

			// valid inputs
			if (!isset($_GET['app_id']) || is_empty($_GET['app_id'])) {
				_error(404);
			}

			// oauth app
			$user->oauth_app($_GET['app_id']);
			break;

		case 'authorize':
			// valid inputs
			if (!isset($_GET['app_id']) || is_empty($_GET['app_id'])) {
				return_json(array('error' => true, 'message' => "Bad Request, invalid app_id"));
			}
			if (!isset($_GET['app_secret']) || is_empty($_GET['app_secret'])) {
				return_json(array('error' => true, 'message' => "Bad Request, invalid app_secret"));
			}
			if (!isset($_GET['auth_key']) || is_empty($_GET['auth_key'])) {
				return_json(array('error' => true, 'message' => "Bad Request, invalid auth_key"));
			}

			// authorize app
			$access_token = $user->authorize_app($_GET['app_id'], $_GET['app_secret'], $_GET['auth_key']);
			return_json(array('access_token' => $access_token));
			break;

		case 'get_user_info':
			// valid inputs
			if (!isset($_GET['access_token']) || is_empty($_GET['access_token'])) {
				return_json(array('error' => true, 'message' => "Bad Request, invalid access_token"));
			}

			// access app
			$user_id = $user->access_app($_GET['access_token']);

			// get user
			$get_user = $db->query(sprintf("SELECT 
				user_id, 
				user_name, 
				user_email, 
				user_firstname, 
				user_lastname, 
				user_gender, 
				user_birthdate, 
				user_picture, 
				user_cover, 
				user_registered, 
				user_verified, 
				user_relationship, 
				user_biography,
				user_website
				FROM users WHERE user_id = %s", secure($user_id, 'int'))) or _error("SQL_ERROR_THROWEN");
			if ($get_user->num_rows > 0) {
				while ($_user = $get_user->fetch_assoc()) {
					$_user['profile_picture'] = get_picture($_user['profile_picture'], $_user['user_gender']);
					$_user['user_gender'] = $user->get_gender($_user['user_gender']);
					$_user['profile_cover'] = $system['system_uploads'] . "/" . $_user['profile_cover'];
					$return['user_info'] = $_user;
				}
			}

			// return & exit
			return_json($return);
			break;

        case 'ws_auth':
            user_access();
            /** @var $user User */
            return_json([
                'key' => shntrToken::encrypt(json_encode([$user->_data['user_id'], microtime(true)]))
            ]);
            break;
        case 'ws_check':
            $payload = @file_get_contents('php://input');
            $_POST = json_decode($payload, true);
            @[$user_id, $time] = json_decode(shntrToken::decrypt($_POST['param']), true);

            if (false && time() - $time > 1000) {
                return_json([
                    $user_id, $time, $_POST['param'],
                    'userId' => false,
                ]);
            }

            [$id] = $db->query(
                sprintf(
                    'select user_id from users where user_id = %s limit 1',
                    secure($user_id)
                )
            )->fetch_row();

            return_json([
                'userId' => $id,
            ]);
            break;

        case 'relysia_treasury_token':
            return_json([
                'token' => shntrToken::getAccessToken()
            ]);
            break;

        case 'relysia_balance_refresh':
            $payload = @file_get_contents('php://input');
            $_POST = json_decode($payload, true);

            $result = $db->query(
                sprintf(
                    'select user_id from users where user_relysia_paymail = %s
                    union 
                    select user_id from users where user_relysia_paymail = %s',
                    secure($_POST['sender'] ?? ''),
                    secure($_POST['receiver'] ?? '')
                )
            );

            $balances = [];

            if ($result) {
                while ([$userId] = $result->fetch_row()) {
                    $balance = [
                        'id' => $userId,
                        'balance' => shntrToken::getRelysiaBalance($userId, true),
                    ];

                    $db->query(
                        sprintf(
                            'upsate users_relysia set balance = %s where user_id = %s',
                            secure($balance['id']),
                            secure($balance['balance'])
                        )
                    );

                    $balances[] = $balance;
                }
            } else {
                error_log('relysia_balance_refresh: ' . $db->error);
            }

            return_json($balances);
            break;

		default:
			return_json(array('error' => true, 'message' => "Bad Request, invalid parameters"));
			break;
	}
} catch (Exception $e) {
	if ($_GET['do'] == "oauth") {
		_error(__("Error"), $e->getMessage());
	} else {
		return_json(array('error' => true, 'message' => $e->getMessage()));
	}
}
