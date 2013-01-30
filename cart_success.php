<?php
	/**
	 * Elgg cart - success page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	global $CONFIG;
	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}

	// Set stores title
		$title = elgg_view_title(elgg_echo('cart:success'));
		
	// Get objects
		set_context('order');
		$body = elgg_echo('cart:success:content');
		$area2 .= <<< AREA2
			<div class="search_listing_info">
				<br>{$body}<br><br>
			</div>
AREA2;
		$area2 .= elgg_view("{$CONFIG->pluginname}/cart_success");
		
		set_context('stores');
		
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores">
				{$area2}
			</div>
EOF;
		// Delete Cart;
		if($cart = get_entities('object','cart',$user_guid)){
			$cart = $cart[0];
			$cart_items = get_entities_from_relationship('cart_item',$cart->guid);
			if($cart_items){
				foreach ($cart_items as $cart_item){
					$cart_item->delete();
				}
			}
			$cart->delete();
		}
	// These for left side menu
		$area1 .= gettags();
		//$area1 .= get_storestype_cloud(page_owner());
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo("stores:your"),page_owner_entity()->name), $body);
	
?>