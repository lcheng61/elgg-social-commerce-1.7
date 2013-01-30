<?php
	/**
	 * Elgg view - sold products
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/ 

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	gatekeeper();
	global $CONFIG;
	$title = elgg_view_title($title = elgg_echo('stores:sold:products'));
	
	set_context('search');
	
	$limit = 10;
	$offset = get_input('offset');
	if(!$offset)
		$offset = 0;
	$sold_products = get_sold_products($_SESSION['user']->guid,$limit,$offset);
	$count = get_data("SELECT FOUND_ROWS( ) AS count");
	$count = $count[0]->count;
	if($sold_products){
		$baseurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$nav = elgg_view('navigation/pagination',array(
									'baseurl' => $baseurl,
									'offset' => $offset,
									'count' => $count,
									'limit' => $limit
								));
		$area2 = "";
		foreach ($sold_products as $sold_product){
			$sold_product = get_entity($sold_product->value);
			$area2 .= elgg_view("{$CONFIG->pluginname}/sold_products",array('entity'=>$sold_product));
		}
		$area2 = $nav.$area2.$nav;
	}else{
		$area2 = elgg_echo('no:data');
	}
	//$area2 = list_user_friends_objects(page_owner(),'stores',10,'',false);
	$area2 = <<<EOF
		{$title}
		<div class="contentWrapper stores">
			{$area2}
		</div>
EOF;
	set_context('socialcommerce');
	//$area1 = get_filetype_cloud(page_owner(), true);
	// These for left side menu
	$area1 .= gettags();
	$body = elgg_view_layout('two_column_left_sidebar',$area1, $area2);
	
	// Finally draw the page
	page_draw(sprintf(elgg_echo("stores:sold"),$_SESSION['user']->name), $body);
?>