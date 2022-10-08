<?php

/**
 * ajax -> posts -> product
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

// check if market enabled
if (!$system['market_enabled']) {
	modal("MESSAGE", __("Error"), __("This feature has been disabled by the admin"));
}

// check market permission
if (!$user->_data['can_sell_products']) {
	modal("MESSAGE", __("Error"), __("You don't have the permission to do this"));
}

try {

	// initialize the return array
	$return = array();

	switch ($_REQUEST['do']) {
		case 'create':
			$query = $db->query("SELECT * FROM prices WHERE price_name = 'product_price';");
			$price = $query->fetch_assoc();
            $smarty->assign('price', $price['price']);
			// assign variables
            if (isset($_GET['category_id'])) {
                    $smarty->assign('market_category', $user->get_category("market_categories", $_GET['category_id']));
            } else {
                $smarty->assign('market_categories', $user->get_categories("market_categories"));
            }
			$smarty->assign('custom_fields', $user->get_custom_fields(array("for" => "product")));

			// return
			$return['template'] = $smarty->fetch("ajax.product.publisher.tpl");
			$return['callback'] = "$('#modal').modal('show'); $('.modal-content:last').html(response.template); initialize_modal();";
			break;

		case 'publish':
			// valid inputs
			/* filter product */
			if (!isset($_POST['product'])) {
				_error(400);
			}
			$_POST['product'] = json_decode($_POST['product']);
			if (!is_object($_POST['product'])) {
				_error(400);
			}

      if (empty($user->_data['user_relysia_password'])) {
          $user->register_to_relysia(
              $user->_data['user_name'], $user->_data['user_id']
          );
      }
      $balance = shntrToken::getRelysiaBalance();
      $query = $db->query("SELECT * FROM prices WHERE price_name = 'product_price';");
      $price = $query->fetch_assoc();
      if ($balance < $price['price']) {
          modal("ERROR", __("Funds"), __("You're out of tokens"));
      }

			/* check product name */
			if (is_empty($_POST['product']->name)) {
				return_json(array('error' => true, 'message' => __("Please add your product name")));
			}
			/* check product price */
			if (is_empty($_POST['product']->price)) {
				return_json(array('error' => true, 'message' => __("Please add your product price")));
			}
			if (!is_numeric($_POST['product']->price) || $_POST['product']->price < 0) {
				return_json(array('error' => true, 'message' => __("Please add valid product price (0 for free or more)")));
			}
			/* check product category */
			if (!$user->get_category("market_categories", $_POST['product']->category)) {
				return_json(array('error' => true, 'message' => __("Please select valid product category")));
			}
			/* check product status */
			if (!in_array($_POST['product']->status, array('new', 'old'))) {
				return_json(array('error' => true, 'message' => __("Please select valid product status")));
			}
			/* filter photos */
			$photos = array();
			if (isset($_POST['photos'])) {
				$_POST['photos'] = json_decode($_POST['photos']);
				if (!is_object($_POST['photos'])) {
					_error(400);
				}
				/* filter the photos */
				foreach ($_POST['photos'] as $photo) {
					$photos[] = (array) $photo;
				}
				if (count($photos) == 0) {
					_error(400);
				}
			}

			/* filter files */
			$files = array();
			if (isset($_POST['files'])) {
				$_POST['files'] = json_decode($_POST['files']);
				if (!is_object($_POST['files'])) {
					_error(400);
				}
				/* filter the files */
				foreach ($_POST['files'] as $file) {
					$files[] = (array) $file;
				}

				if (count($files) == 0) {
					_error(400);
				}
			}
			/* set custom fields */
			try {
				$inputs['custom_fields'] = $user->set_custom_fields($_POST['product'], 'product');
			} catch (Exception $e) {
				return_json(array('error' => true, 'message' => $e->getMessage()));
			}

			/* prepare inputs */
			$inputs['handle'] = "me";
			$inputs['privacy'] = "public";
			$inputs['is_anonymous'] = '0';
			$inputs['message'] = $_POST['message'];
			$inputs['product'] = $_POST['product'];
			$inputs['photos'] = $photos;
			$inputs['files'] = $files;

			// publish
			$post = $user->publisher($inputs);

			// return
			$return['callback'] = "window.location = '" . $system['system_url'] . "/posts/" . $post['post_id'] . "';";
			break;

		case 'edit':
			// valid inputs
			if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
				_error(400);
			}

			// get post
			$post = $user->get_post($_GET['post_id']);
			if (!$post) {
				_error(400);
			}
			/* assign variables */
			$smarty->assign('post', $post);
            if (isset($_GET['category_id'])) {
                $smarty->assign('market_category', $user->get_category("market_categories", $_GET['category_id']));
            } else {
                $smarty->assign('market_categories', $user->get_categories("market_categories"));
            }
			$smarty->assign('custom_fields', $user->get_custom_fields(array("for" => "product", "get" => "settings", "node_id" => $_GET['post_id'])));

            // return
			$return['template'] = $smarty->fetch("ajax.product.editor.tpl");
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
