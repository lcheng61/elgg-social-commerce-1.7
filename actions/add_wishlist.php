<?php

	/**
	 * Elgg wishlist - add action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
	 **/

	global $CONFIG;
	if (!isloggedin()) {
		system_message(elgg_echo("add:wishlist:not:login"));
		$_SESSION['last_forward_from'] = current_page_url();
		forward();
	}else {
		$product_guid = (int) get_input('pgid');
		if($product_guid > 0){
			$product = get_entity($product_guid);
			$product_type_details = get_product_type_from_value($product->product_type_id);
			if($product_type_details->addto_cart != 1){
				$reditrect = $product->getURL();
				forward($reditrect);
			}
			if($product->status != 1 || $_SESSION['user']->guid == $product->owner_guid){
				forward();
			}
		}else{
			forward();
		}
	}
	
	// Get variables
	if($product && $product_guid && $product_guid > 0){
		if(check_entity_relationship($_SESSION['user']->guid,'wishlist',$product_guid)){
			system_message(elgg_echo("wishlist:already:added"));
		}else{
			$result = add_entity_relationship($_SESSION['user']->guid,'wishlist',$product_guid);
			if($result){
				system_message(elgg_echo("wishlist:added"));
			}else {
				register_error(elgg_echo("wishlist:added:failed"));
			}
		}
	}
	
	$return = $CONFIG->url . "pg/{$CONFIG->pluginname}/" . $product->getOwnerEntity()->username . "/read/" . $product->getGUID() . "/" . $product->title;
	forward($return);
?>