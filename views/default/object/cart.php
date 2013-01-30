<?php
	/**
	 * Elgg cart - individual view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/ 

	global $CONFIG;
	
	$cart = $vars['entity'];
	
	$cart_guid = $cart->getGUID();
	$title = $cart->title;
	$desc = $cart->description;
	$quantity = $cart->quantity;
	$product_guid = $cart->product_id;
	if($product = get_entity($product_guid)){
		$product_url = $product->getURL();
		$title = $product->title;
		$mime = $product->mimetype;
	}
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	
	if (get_context() == "search") {	// Start search listing version 
		$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
		$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
		$info .= "</p>";
		$info .= elgg_cart_quantity($cart);
		//$info .= "<a href=".$vars['url']."action/stores/remove_cart?cart_guid=".$cart->getGUID().">".elgg_echo('remove')."</a>&nbsp"; 
		$info .= "<div class=\"stores_remove\">".elgg_view('output/confirmlink',array(
							'href' => $vars['url'] . "action/{$CONFIG->pluginname}/remove_cart?cart_guid=" . $cart->getGUID(),
							'text' => elgg_echo("remove"),
							'confirm' => elgg_echo("cart:delete:confirm")
						))."</div>"; 
		$icon = elgg_view("{$CONFIG->pluginname}/image", array(
												'entity' => $product,
												'size' => 'small',
											  )
										);
		
		echo elgg_view_listing($icon, $info);
	}elseif (get_context() == "confirm") {
		$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
		$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
		$info .= "</p>";
		$info .= elgg_cart_quantity($cart);
		
		$icon = elgg_view("{$CONFIG->pluginname}/image", array(
												'entity' => $product,
												'size' => 'small',
											  )
										);
		echo elgg_view_listing($icon, $info);
	}elseif (get_context() == "order") {	// Start search listing version 
		$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
		$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
		$info .= "</p>";
		$info .= elgg_cart_quantity($cart);
		
		$icon = elgg_view("{$CONFIG->pluginname}/image", array(
												'entity' => $product,
												'size' => 'small',
											  )
										);
		
		echo elgg_view_listing($icon, $info);
	}
?>