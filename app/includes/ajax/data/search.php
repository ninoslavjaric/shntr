<?php

/**
 * ajax -> data -> search
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// valid inputs
if (!isset($_POST['query'])) {
	_error(400);
}

try {

	// initialize the return array
	$return = array();

	// get results
	$results = $user->search_quick($_POST['query']);
	if ($results) {
		/* assign variables */
		if ($_POST['people']) {
			$res = [];
			for ($i=0; $i < count($results); $i++) {
				if ($results[$i]['user_id']) {
					array_push($res, $results[$i]);
				}
			}
			if (count($res)>0) {
				$smarty->assign('results', $res);
				$return['results'] = $smarty->fetch("ajax.search.tpl");
			}
		}else {
			$smarty->assign('results', $results);
			/* return */
			$return['results'] = $smarty->fetch("ajax.search.tpl");
		}
	}

	// return & exit
	return_json($return);
} catch (Exception $e) {
	modal("ERROR", __("Error"), $e->getMessage());
}
