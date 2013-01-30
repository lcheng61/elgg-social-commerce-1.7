<?php
	/**
	 * Elgg cart - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		global $CONFIG;
		
		if (!isloggedin()) {
			$_SESSION['last_forward_from'] = current_page_url();
			forward();
		}elseif (isloggedin()){
			// Get the current page's owner
			$page_owner = page_owner_entity();
			if ($page_owner === false || is_null($page_owner)) {
				$page_owner = $_SESSION['user'];
				set_page_owner($_SESSION['guid']);
			}
			if(page_owner() != $_SESSION['user']->guid){
				forward("pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username . "/cart/");
			}
			$header_title = elgg_echo('my:shopping:cart');
			$title = elgg_view_title($header_title);
		}

		
	
		
	// Get objects
		set_context('search');
		$area2 = elgg_view("{$CONFIG->pluginname}/cart");
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;

	// These for left side menu
		$area1 .= gettags();
		//$area1 .= get_storestype_cloud(page_owner());
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
		if($CONFIG->cart_item_count){
			$count = " (".$CONFIG->cart_item_count.")";
		}
	// Finally draw the page
		
		page_draw(sprintf($header_title.$count,page_owner_entity()->name), $body);
	
?>