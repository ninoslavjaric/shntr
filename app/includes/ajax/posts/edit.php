<?php

/**
 * ajax -> posts -> edit
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

	switch ($_POST['handle']) {
		case 'comment':
			// valid inputs
			if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
				_error(400);
			}
			/* if message not set */
			if (!isset($_POST['message'])) {
				_error(400);
			}
			/* filter comment photo */
			if (isset($_POST['photo'])) {
				$_POST['photo'] = json_decode($_POST['photo']);
			}

			// edit comment
			$comment = $user->edit_comment($_POST['id'], $_POST['message'], $_POST['photo']);
			/* assign variables */
			$smarty->assign('_comment', $comment);

			// return
			$return['comment'] = $smarty->fetch("__feeds_comment.text.tpl");
			break;

		case 'post':
			// valid inputs
			if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
				_error(400);
			}
			/* if message not set */
			if (!isset($_POST['message'])) {
				_error(400);
			}

			// edit post
			$post = $user->edit_post($_POST['id'], $_POST['message']);
			/* assign variables */
			$smarty->assign('post', $post);

			// return
			$return['post'] = $smarty->fetch("__feeds_post.text.tpl");
			break;

		case 'buy-product':
            if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
                _error(400);
            }

            $post = $user->get_post($_POST['id']);

            if (($paywallPrice = $user->paywalled($post['user_id']))) {
                modal(
                    "ERROR",
                    __('Paywalled'),
                    __("You're paywalled by {$post['user_firstname']}. Paywall users aren't able to buy this.")
                );
            }

//            if ($post['product']['buying_candidate_id'] != $user->_data['user_id']) {
//                _error(403);
//            }

            $owner = $user->get_user($post['user_id']);

            $db->begin_transaction();
            try {
                $resp = shntrToken::pay(
                    $user->_data['user_token_private_key'],
                    $owner['user_token_address'],
                    floatval($post['product']['price'])
                );
                if (!str_contains($resp['message'], 'success')) {
                    throw new Exception($resp['message']);
                }

                shntrToken::noteTransaction(
                    floatval($post['product']['price']), intval($user->_data['user_id']), $owner['user_id'], 'post_products', $post['product']['product_id'], 'Buying product'
                );

                $db->query("UPDATE posts_products SET sold = 1, buying_candidate_id = {$user->_data['user_id']} WHERE product_id = " . intval($post['product']['product_id']));

                $db->commit();
            } catch (Exception $e) {
                $db->rollback();

                _error(403);
            }

			try {
				$fetchData = $db->query(sprintf("select users.user_email, users.user_name FROM users, posts where posts.post_id = %s and posts.user_id = users.user_id", secure($_POST['id'], 'int')));
				$row = $fetchData->fetch_assoc();
				if ($row) {
					$seller_email = $row['user_email'];
					$seller_name = $row['user_name'];
				}

				$fetchData = $db->query(sprintf("SELECT user_email, user_name FROM users WHERE user_id = %s", secure($user->_data['user_id'],'int'))) or _error("SQL_ERROR");
				$row = $fetchData->fetch_assoc();
				if ($row) {
					$buyer_email = $row['user_email'];
					$buyer_name = $row['user_name'];
				}

				$fetchData = $db->query(sprintf("SELECT price, name FROM posts_products WHERE post_id = %s", secure($_POST['id'],'int'))) or _error("SQL_ERROR");
				$row = $fetchData->fetch_assoc();
				if ($row) {
					$price = $row['price'];
					$product_name = $row['name'];
				}

				$link_product = "<a href='test.shntr.com/post/".$_POST['id']."'>".$product_name."</a>";

				$buy_date = date("d.m.Y");
				//send email to buyer
				$buyer_subject = "Successfully bought a product on shntr";

				$buyer_message = "<p>Dear ".$buyer_name."</p> 

				<p>You have bought ".$link_product." for ".$price." tokens on ".$buy_date.".</p>
				
				<p>Best regards,</p>
				<p>shntr team</p>";

				$buyer_retval = _email ($buyer_email, $buyer_subject, $buyer_message, 'Success');

				//send email to seller
				$seller_subject = "Successfully sold a product on shntr";

				$seller_message = "<p>Dear ".$seller_name."</>

				<p>User ".$buyer_name." has bought your product ".$link_product." for ".$price." tokens  on ".$buy_date.".</p>
				
				<p>Best regards,</p>
				<p>shntr team</p>";

				$seller_retval = _email ($seller_email, $seller_subject, $seller_message, 'Success');

			} catch (Exception $e) {
				_error("Error", $e->getMessage());
			}

            $return['callback'] = 'window.location = "' . $system['system_url'] . '/posts/' . $_POST['id'] . '";';
            break;

		case 'sell-token':

			$send_data = $_POST['send_data'];
			$name = $send_data['name'];
			$address = $send_data['address'];
			$country = $send_data['country'];
			$iban = $send_data['iban'];
			$amount = $send_data['amount'];
            $server_add = '138UEaYBA7FLgiyuESNhenogM37PE6YNwU';

            try {
                if ($amount < 10000) {
                    break;
                }
            	$balance = shntrToken::getBalance();
				//not enough balance
				// if ($amount>$balance) {
				// 	$return['callback'] = 'no_enough_balance';
				// 	break;
				// }
                $resp = shntrToken::pay(
                    $user->_data['user_token_private_key'],
                    $server_add,
                    $amount
                );
                if (!str_contains($resp['message'], 'success')) {
                    throw new Exception($resp['message']);
                }

				$user_id = $user->_data['user_id'];
				$user_name = $user->_data['user_name'];
				$user_email = $user->_data['user_email'];
				$slist_state = 'pending';

				$result = $db->query("INSERT INTO info_sell_token (user_id, user_name, name, user_email, address, country, iban, sell_amount_token, state, post_time) VALUES ('".$user_id."', '".$name."', '".$user_name."', '".$user_email."', '".$address."', '".$country."', '".$iban."', '".$amount."', '".$slist_state."', '".date("d.m.Y")."');");

            } catch (Exception $e) {
                _error(403);
            }

			$return['callback'] = 'Sell successfully';
		    break;

		case 'product':
			// valid inputs
			/* if id is set & not numeric */
			if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
				_error(400);
			}
			/* if product info not set */
			if (!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['category']) || !isset($_POST['status']) || !isset($_POST['location']) || !isset($_POST['message'])) {
				_error(400);
			}
			/* check product name */
			if (is_empty($_POST['name'])) {
				return_json(array('error' => true, 'message' => __("Please add your product name")));
			}
			/* check product price */
			if (is_empty($_POST['price'])) {
				return_json(array('error' => true, 'message' => __("Please add your product price")));
			}
			if (!is_numeric($_POST['price']) || $_POST['price'] < 0) {
				return_json(array('error' => true, 'message' => __("Please add valid product price (0 for free or more)")));
			}
			/* check product category */
			if (!$user->get_category("market_categories", $_POST['category'])) {
				return_json(array('error' => true, 'message' => __("Please select valid product category")));
			}
			/* check product status */
			if (!in_array($_POST['status'], array('new', 'old'))) {
				return_json(array('error' => true, 'message' => __("Please select valid product status")));
			}
			/* set custom fields */
			try {
				$user->set_custom_fields($_POST, "product", "settings", $_POST['id']);
			} catch (Exception $e) {
				return_json(array('error' => true, 'message' => $e->getMessage()));
			}

			// edit product
			$user->edit_product($_POST['id'], $_POST['message'], $_POST);

			// return
			$return['callback'] = 'window.location = "' . $system['system_url'] . '/posts/' . $_POST['id'] . '";';
			break;

		case 'funding':
			// valid inputs
			/* if id is set & not numeric */
			if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
				_error(400);
			}
			/* check funding title */
			if (is_empty($_POST['title'])) {
				return_json(array('error' => true, 'message' => __("Add title for your funding request")));
			}
			if (strlen($_POST['title']) < 3) {
				return_json(array('error' => true, 'message' => __("Minimum funding title is 3 characters")));
			}
			if (strlen($_POST['title']) > 100) {
				return_json(array('error' => true, 'message' => __("Maximum funding title is 100 characters")));
			}
			/* check funding amount */
			if (is_empty($_POST['amount'])) {
				return_json(array('error' => true, 'message' => __("Please the amount you would like to receive")));
			}
			if (!is_numeric($_POST['amount']) || $_POST['amount'] <= 0) {
				return_json(array('error' => true, 'message' => __("Please add valid funding amount")));
			}
			/* check funding description */
			if (is_empty($_POST['description'])) {
				return_json(array('error' => true, 'message' => __("Add description for your funding request")));
			}
			if (strlen($_POST['description']) < 32) {
				return_json(array('error' => true, 'message' => __("Minimum funding description is 32 characters")));
			}
			if (strlen($_POST['description']) > 1000) {
				return_json(array('error' => true, 'message' => __("Maximum funding description is 1000 characters")));
			}
			/* check funding cover image */
			if (is_empty($_POST['cover_image'])) {
				return_json(array('error' => true, 'message' => __("Add cover image for your funding request")));
			}

			// edit funding
			$user->edit_funding($_POST['id'], $_POST['description'], $_POST);

			// return
			$return['callback'] = 'window.location = "' . $system['system_url'] . '/posts/' . $_POST['id'] . '";';
			break;

		case 'offer':
			// valid inputs
			if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
				_error(400);
			}
			/* check discount type */
			switch ($_POST['discount_type']) {
				case 'discount_percent':
					if (is_empty($_POST['discount_percent']) || !is_numeric($_POST['discount_percent']) || $_POST['discount_percent'] > 99 || $_POST['discount_percent'] < 1) {
						return_json(array('error' => true, 'message' => __("Select valid discount percent")));
					}
					break;

				case 'discount_amount':
					if (is_empty($_POST['discount_amount']) || !is_numeric($_POST['discount_amount']) || $_POST['discount_amount'] <= 0) {
						return_json(array('error' => true, 'message' => __("Enter valid discount amount")));
					}
					break;

				case 'buy_get_discount':
					if (is_empty($_POST['buy_x']) || !is_numeric($_POST['buy_x']) || $_POST['buy_x'] <= 0) {
						return_json(array('error' => true, 'message' => __("Enter valid Buy X amount")));
					}
					if (is_empty($_POST['get_y']) || !is_numeric($_POST['get_y']) || $_POST['get_y'] <= 0) {
						return_json(array('error' => true, 'message' => __("Enter valid Get Y amount")));
					}
					break;

				case 'spend_get_off':
					if (is_empty($_POST['spend_x']) || !is_numeric($_POST['spend_x']) || $_POST['spend_x'] <= 0) {
						return_json(array('error' => true, 'message' => __("Enter valid Spend X amount")));
					}
					if (is_empty($_POST['amount_y']) || !is_numeric($_POST['amount_y']) || $_POST['amount_y'] <= 0) {
						return_json(array('error' => true, 'message' => __("Enter valid Amount Y amount")));
					}
					break;

				case 'free_shipping':
					# do nothing
					break;

				default:
					return_json(array('error' => true, 'message' => __("Select valid discount type for your offer")));
					break;
			}
			/* check end date */
			if (is_empty($_POST['end_date'])) {
				return_json(array('error' => true, 'message' => __("Add end date for your offer")));
			}
			if (strtotime(set_datetime($_POST['end_date'])) <= strtotime($date)) {
				throw new Exception(__("End date must be after today datetime"));
			}
			/* check offer category */
			if (is_empty($_POST['category'])) {
				return_json(array('error' => true, 'message' => __("select valid category for your offer")));
			}
			$check = $db->query(sprintf("SELECT COUNT(*) as count FROM offers_categories WHERE category_id = %s", secure($_POST['category'], 'int'))) or _error("SQL_ERROR_THROWEN");
			if ($check->fetch_assoc()['count'] == 0) {
				return_json(array('error' => true, 'message' => __("select valid category for your offer")));
			}
			/* check offer title */
			if (is_empty($_POST['title'])) {
				return_json(array('error' => true, 'message' => __("Add title for your offer")));
			}
			if (strlen($_POST['title']) < 3) {
				return_json(array('error' => true, 'message' => __("Minimum offer title is 3 characters")));
			}
			if (strlen($_POST['title']) > 100) {
				return_json(array('error' => true, 'message' => __("Maximum offer title is 100 characters")));
			}
			/* check offer description */
			if (is_empty($_POST['description'])) {
				return_json(array('error' => true, 'message' => __("Add description for your offer")));
			}
			if (strlen($_POST['description']) < 32) {
				return_json(array('error' => true, 'message' => __("Minimum offer description is 32 characters")));
			}
			if (strlen($_POST['description']) > 1000) {
				return_json(array('error' => true, 'message' => __("Maximum offer description is 1000 characters")));
			}
			/* check offer thumbnail */
			if (is_empty($_POST['thumbnail'])) {
				return_json(array('error' => true, 'message' => __("Add thumbnail for your offer")));
			}
			/* set custom fields */
			try {
				$user->set_custom_fields($_POST, "offer", "settings", $_POST['id']);
			} catch (Exception $e) {
				return_json(array('error' => true, 'message' => $e->getMessage()));
			}

			// edit offer
			$user->edit_offer($_POST['id'], $_POST['description'], $_POST);

			// return
			$return['callback'] = 'window.location = "' . $system['system_url'] . '/posts/' . $_POST['id'] . '";';
			break;

		case 'job':
			// valid inputs
			if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
				_error(400);
			}
			/* check job title */
			if (is_empty($_POST['title'])) {
				return_json(array('error' => true, 'message' => __("Add title for your job")));
			}
			if (strlen($_POST['title']) < 3) {
				return_json(array('error' => true, 'message' => __("Minimum job title is 3 characters")));
			}
			if (strlen($_POST['title']) > 100) {
				return_json(array('error' => true, 'message' => __("Maximum job title is 100 characters")));
			}
			/* check job location */
			if (is_empty($_POST['location'])) {
				return_json(array('error' => true, 'message' => __("Add location for your job")));
			}
			/* check salary range */
			if (is_empty($_POST['salary_minimum']) || !is_numeric($_POST['salary_minimum']) || $_POST['salary_minimum'] <= 0) {
				return_json(array('error' => true, 'message' => __("Enter valid minimum salary")));
			}
			if (is_empty($_POST['salary_maximum']) || !is_numeric($_POST['salary_maximum']) || $_POST['salary_maximum'] <= 0) {
				return_json(array('error' => true, 'message' => __("Enter valid maximum salary")));
			}
			if (!in_array($_POST['pay_salary_per'], ['per_hour', 'per_day', 'per_week', 'per_month', 'per_year'])) {
				return_json(array('error' => true, 'message' => __("Select valid salary payment period")));
			}
			/* check job type */
			if (!in_array($_POST['type'], ['full_time', 'part_time', 'internship', 'volunteer', 'contract'])) {
				return_json(array('error' => true, 'message' => __("Select valid job type")));
			}
			/* check job category */
			if (is_empty($_POST['category'])) {
				return_json(array('error' => true, 'message' => __("select valid category for your job")));
			}
			$check = $db->query(sprintf("SELECT COUNT(*) as count FROM jobs_categories WHERE category_id = %s", secure($_POST['category'], 'int'))) or _error("SQL_ERROR_THROWEN");
			if ($check->fetch_assoc()['count'] == 0) {
				return_json(array('error' => true, 'message' => __("select valid category for your job")));
			}
			/* check job description */
			if (is_empty($_POST['description'])) {
				return_json(array('error' => true, 'message' => __("Add description for your job")));
			}
			if (strlen($_POST['description']) < 32) {
				return_json(array('error' => true, 'message' => __("Minimum job description is 32 characters")));
			}
			if (strlen($_POST['description']) > 1000) {
				return_json(array('error' => true, 'message' => __("Maximum job description is 1000 characters")));
			}
			/* check question #1 */
			if ($_POST['question_1_type'] == "multiple_choice") {
				if (is_empty($_POST['question_1_title'])) {
					return_json(array('error' => true, 'message' => __("Enter your question") . " #1"));
				}
				if (is_empty($_POST['question_1_choices'])) {
					return_json(array('error' => true, 'message' => __("Enter choices for your question") . " #1"));
				}
			} else {
				$_POST['question_1_type'] = (is_empty($_POST['question_1_title'])) ? "" : $_POST['question_1_type'];
			}
			/* check question #2 */
			if ($_POST['question_2_type'] == "multiple_choice") {
				if (is_empty($_POST['question_2_title'])) {
					return_json(array('error' => true, 'message' => __("Enter your question") . " #2"));
				}
				if (is_empty($_POST['question_2_choices'])) {
					return_json(array('error' => true, 'message' => __("Enter choices for your question") . " #2"));
				}
			} else {
				$_POST['question_2_type'] = (is_empty($_POST['question_1_title'])) ? "" : $_POST['question_2_type'];
			}
			/* check question #3 */
			if ($_POST['question_3_type'] == "multiple_choice") {
				if (is_empty($_POST['question_3_title'])) {
					return_json(array('error' => true, 'message' => __("Enter your question") . " #3"));
				}
				if (is_empty($_POST['question_3_choices'])) {
					return_json(array('error' => true, 'message' => __("Enter choices for your question") . " #3"));
				}
			} else {
				$_POST['question_3_type'] = (is_empty($_POST['question_1_title'])) ? "" : $_POST['question_3_type'];
			}
			/* check job cover */
			if (is_empty($_POST['cover_image'])) {
				return_json(array('error' => true, 'message' => __("Add cover image for your job")));
			}
			/* set custom fields */
			try {
				$user->set_custom_fields($_POST, "job", "settings", $_POST['id']);
			} catch (Exception $e) {
				return_json(array('error' => true, 'message' => $e->getMessage()));
			}

			// edit job
			$user->edit_job($_POST['id'], $_POST['description'], $_POST);

			// return
			$return['callback'] = 'window.location = "' . $system['system_url'] . '/posts/' . $_POST['id'] . '";';
			break;

		case 'privacy':
			// valid inputs
			/* if id is set & not numeric */
			if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
				_error(400);
			}
			/* if privacy set and not valid */
			if (!isset($_POST['privacy']) || !in_array($_POST['privacy'], array('me', 'friends', 'public'))) {
				_error(400);
			}

			// edit privacy
			$post = $user->edit_privacy($_POST['id'], $_POST['privacy']);
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
