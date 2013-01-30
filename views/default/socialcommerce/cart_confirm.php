<?php
/**
 * Elgg view - cart confirm page
 * 
 * @package Elgg SocialCommerce
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Cubet Technologies
 * @copyright Cubet Technologies 2009-2010
 * @link http://elgghub.com/
 **/ 
	 
global $CONFIG;
		
$cart = get_entities('object','cart',$_SESSION['user']->getGUID());
if($cart){
	$cart = $cart[0];
	$cart_items = get_entities_from_relationship('cart_item',$cart->guid);
	if($cart_items){
		foreach ($cart_items as $cart_item){
			if($product = get_entity($cart_item->product_id)){
				$product_url = $product->getURL();
				$title = $product->title;
				$mime = $product->mimetype;
				$tags = $product->tags;
				$category = $product->category;
				if($category > 0){
					$category = get_entity($category);
				}
				
				$owner = $cart_item->getOwnerEntity();
				$friendlytime = friendly_time($cart_item->time_created);
				
				$info = "<p> <a href=\"{$product_url}\">{$title}</a></p>";
				$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
				$info .= "</p>";
				$tags_out =  elgg_view('output/tags',array('value' => $tags));
				$product_type_out =  elgg_view('output/product_type',array('value' => $product->product_type_id));
				$category_out =  elgg_view('output/category',array('value' => $category->title));
				$info .= <<<EOF
					<table style="margin-top:3px;width:100%;">
						<tr>
							<td style="width:300px;">
								<div class="object_tag_string">{$tags_out}</div>
							</td>
							<td>
								<div style="float:left;">
									{$product_type_out}
								</div>
								<div style="float:left;">
									{$category_out}
								</div>
							</td>
						</tr>
					</table>
EOF;
				$info .= elgg_cart_quantity($cart_item);
				$info .= elgg_view('output/confirmlink',array(
									'href' => $vars['url'] . "action/{$CONFIG->pluginname}/remove_cart?cart_guid=" . $cart_item->getGUID(),
									'text' => elgg_echo("remove"),
									'confirm' => elgg_echo("cart:delete:confirm"),
								)); 
				$image = elgg_view("{$CONFIG->pluginname}/image", array(
											'entity' => $product,
											'size' => 'medium',
											'display'=>'full'
										  )
									);
				if($product->mimetype && $product->product_type_id == 2){							
					$icon = "<div style=\"padding-top:10px;\"><a href=\"{$product->getURL()}\">" . elgg_view("{$CONFIG->pluginname}/icon", array("mimetype" => $mime, 'thumbnail' => $product->thumbnail, 'stores_guid' => $product->guid, 'size' => 'small')) . "</a></div>";
				}
				$display_cart_items .= elgg_view_listing($image.$icon, $info);
			}
		}
		$update_cart = elgg_view("{$CONFIG->pluginname}/forms/updatecart");
		
	}
	$confirm_cart = elgg_view("{$CONFIG->pluginname}/forms/confirm_cart");
	$confirm_address = list_entities("object","address",page_owner(),10);
}

// Set Payment 
if(get_plugin_setting('socialcommerce_paypal_environment', $CONFIG->pluginname)){
	$environment = get_plugin_setting('socialcommerce_paypal_environment', $CONFIG->pluginname);
}else{
	$environment = "sandbox";
}
if($environment == "sandbox"){
	$business = get_plugin_setting('socialcommerce_paypal_email', $CONFIG->pluginname);
	$paypalurl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	
}else if ($environment == "paypal") {
	$business = get_plugin_setting('socialcommerce_paypal_email', $CONFIG->pluginname);
	$paypalurl = "https://www.paypal.com/cgi-bin/webscr";	
}
$cencelurl = $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/".$_SESSION['user']->username."/cancel/";
//$returnurl = $CONFIG->wwwroot."action/stores/add_order?page_owner=".page_owner();
$returnurl = $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/".$_SESSION['user']->username."/cart_success/";
$ipnurl = $CONFIG->wwwroot."action/{$CONFIG->pluginname}/makepayment?page_owner=".page_owner();

echo $cart_body = <<<EOF
	<form name="frm_cart" method="post" action="{$paypalurl}">
		{$display_cart_items}
		{$update_cart}
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="item_name" value="stores_purchase">
		<input type="hidden" name="quantity" value="1">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="paymentaction" value="sale">
		<input type="hidden" name="custom" value="stores_payment">
		<input type="hidden" name="rm" value="2">
		<input type="hidden" name="no_note" value="0">
		<input type="hidden" name="business" value="$business">
		<input type="hidden" name="cancel_return" value="{$cencelurl}">
		<input type="hidden" name="return" value="{$returnurl}">
		<input type="hidden" name="notify_url" value="{$ipnurl}">
		{$confirm_address}
		{$confirm_cart}
	</form>
EOF;
?>