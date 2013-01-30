<?php
	/**
	 * Elgg view - friend's produt
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/ 

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	$title = elgg_view_title($title = elgg_echo('stores:yours:friends'));
	
	set_context('search');
	$search_viewtype = get_input('search_viewtype');
	if($search_viewtype == 'gallery'){
		$limit = 20;
	}else{
		$limit = 10;
	}
	$view = get_input('view');
	$user_guid = $_SESSION['user']->guid;
	if ($friends = get_user_friends($user_guid, $subtype, 999999, 0)) {
		$friendguids = array();
		foreach($friends as $friend) {
			$friendguids[] = $friend->getGUID();
		}
		$area2 = list_entities_from_metadata('status',1,'object','stores',$friendguids,$limit);
	}
	if($view != 'rss'){
		if(empty($area2)){
			$area2 = elgg_echo('product:null');
		}
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;
	}
	set_context('stores');
	//$area1 = get_filetype_cloud(page_owner(), true);
	// These for left side menu
	$area1 .= gettags();
	$body = elgg_view_layout('two_column_left_sidebar',$area1, $area2);
	
	// Finally draw the page
	page_draw(sprintf(elgg_echo("stores:friends"),$_SESSION['user']->name), $body);
?>