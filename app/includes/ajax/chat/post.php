<?php

/**
 * ajax -> chat -> post
 *
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap
require('../../../bootstrap.php');
/**
 * @var $db mysqli
 * @var $user User
 */
// check AJAX Request
is_ajax();

// user access
user_access(true);

// check demo account
if ($user->_data['user_demo']) {
	modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

// if ($user->user_reached_daily_chat_limit()) {
// 	modal('ERROR', __('Chat limitation'), __('You have been reached daily chat limit.'));
// }

// valid inputs
/* if message not set */
if (!isset($_POST['message'])) {
	_error(400);
}
/* filter message photo */
if (isset($_POST['photo'])) {
	$_POST['photo'] = json_decode($_POST['photo']);
}
/* filter message voice note */
if (isset($_POST['voice_note'])) {
	$_POST['voice_note'] = json_decode($_POST['voice_note']);
}
/* if both (conversation_id & recipients) not set */
if (!isset($_POST['conversation_id']) && !isset($_POST['recipients'])) {
	_error(400);
}
/* if conversation_id set but not numeric */
if (isset($_POST['conversation_id']) && !is_numeric($_POST['conversation_id'])) {
	_error(400);
}
/* if recipients not array */
if (isset($_POST['recipients'])) {
	$_POST['recipients'] = json_decode($_POST['recipients']);
	if (!is_array($_POST['recipients'])) {
		_error(400);
	}
	/* recipients must contain numeric values only */
	$_POST['recipients'] = array_filter($_POST['recipients'], 'is_numeric');
	/* check blocking */
	foreach ($_POST['recipients'] as $recipient) {
		if ($user->blocked($recipient)) {
			_error(403);
		}

		$paywallPrice = $user->paywalled($recipient);

		if ($paywallPrice) {
			$paywallUser = $user->get_user_by_id($recipient);
			$paywallUserName = $user->get_user_fullname($paywallUser);

			paywallModal($paywallPrice, $paywallUserName);
		}
	}
} else {
	$interlocutors = $db->query(
		"select user_id from conversations_users where conversation_id = {$_POST['conversation_id']} and user_id <> {$user->_data['user_id']}"
	)->fetch_all(MYSQLI_ASSOC);

	foreach (array_column($interlocutors, 'user_id') as $interlocutor_id) {
        if ($user->paywalled($interlocutor_id)) {
            $user->breach_paywall($interlocutor_id);
        }
	}
}

try {

	// post message
	/* post conversation message */
	$conversation = $user->post_conversation_message($_POST['message'], $_POST['photo'], $_POST['voice_note'], $_POST['conversation_id'], $_POST['recipients']);

	/* remove typing status */
	$user->update_conversation_typing_status($conversation['conversation_id'], false);

	/* add conversation to opened chat boxes session if not */
	if (!in_array($conversation['conversation_id'], $_SESSION['chat_boxes_opened'])) {
		$_SESSION['chat_boxes_opened'][] = $conversation['conversation_id'];
	}

	// return & exit
	return_json($conversation);
} catch (Exception $e) {
	modal("ERROR", __("Error"), $e->getMessage());
}
