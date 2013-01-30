<?php
	/**
	 * Elgg change - order status action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
	 **/ 
	 
	global $CONFIG;
	
	$order_item_guid = get_input('id');
	$order_item_status = get_input('status');
	set_context('add_order');
	if($order_item_guid){
		$order_item = get_entity($order_item_guid);
		if($order_item){
			$order_item_id = $order_item->status = $order_item_status;
			$order_item_id = $order_item->save();
			if($order_item_id){
				echo "<div style='color:green;text-align:center;'>".elgg_echo('order:status:changed')."<div>";
			}else{
				echo "<div style='color:red;text-align:center;'>".elgg_echo('order:status:change:error')."<div>";
			}
		}
	}
	exit;
	/*$redirect = $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/".$_SESSION['user']->username."/read/".$order_item->product_id."/".$order_item->title.$offset;
	forward($redirect);*/
?>