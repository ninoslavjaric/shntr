<?php

/**
 * search
 *
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');

// user access
if ($user->_logged_in || !$system['system_public']) {
	user_access();
}

// valid inputs
$_GET['tab'] = ($_GET['tab'] == "") ? "posts" : $_GET['tab'];
if (!in_array($_GET['tab'], ["posts", "articles", "users", "pages", "groups", "events"])) {
	_error(404);
}

try {
    $current_cities = $user->get_available_current_cities();

    $smarty->assign('current_cities', $current_cities);

    $options = array_diff_key($_GET, array_flip(['query', 'tab', 'hashtag']));
    $smarty->assign('query_string', '?' . http_build_query($options));
    $smarty->assign('query_options', $options);

	// search
	if (isset($_GET['query']) || !empty($options)) {
		/* get results */
		$results = $user->search($_GET['query'], $_GET['tab'], 0, $options);
		/* assign variables */
		$smarty->assign('query', htmlentities($_GET['query'], ENT_QUOTES, 'utf-8'));
		$smarty->assign('hashtag', (isset($_GET['hashtag']) && $_GET['hashtag'] == '1') ? true : false);
		$smarty->assign('results', $results);
	}
	$smarty->assign('tab', $_GET['tab']);

	// get ads campaigns
	$ads_campaigns = $user->ads_campaigns();
	/* assign variables */
	$smarty->assign('ads_campaigns', $ads_campaigns);

	// get ads
	$ads = $user->ads('search');
	/* assign variables */
	$smarty->assign('ads', $ads);

	// get widgets
	$widgets = $user->widgets('search');
	/* assign variables */
	$smarty->assign('widgets', $widgets);
} catch (Exception $e) {
	_error(__("Error"), $e->getMessage());
}

// page header
page_header($system['system_title'] . ' - ' . __("Search"));

// page footer
page_footer("search");
