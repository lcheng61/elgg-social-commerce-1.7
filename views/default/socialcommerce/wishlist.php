<?php
/**
 * Elgg view - wishlist
 * 
 * @package Elgg SocialCommerce
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Cubet Technologies
 * @copyright Cubet Technologies 2009-2010
 * @link http://elgghub.com/
 **/ 
	 
global $CONFIG;

$products = $vars['entities'];
$ts = time();							
if($products){
	foreach ($products as $product){
		$rating = "";
		$owner = $product->getOwnerEntity();
		$friendlytime = friendly_time($product->time_created);
		$title = $product->title;
		$product_url = $product->getURL();
		$title = $product->title;
		$mime = $product->mimetype;
		$friendlytime = "<a href=\"{$vars['url']}pg/{$CONFIG->pluginname}/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
		$info = "<p> <a href=\"{$product_url}\"><B>{$title}</B></a></p>";
		$info .= "<p class=\"owner_timestamp\">{$friendlytime}";
		$info .= "</p>";
		$quantity_text = elgg_echo('quantity');
		$price_text = elgg_echo('price');
		$total = $product->price;
		//$status = elgg_view('stores/product_status',array('entity'=>$order_item,'action'=>'view'));
		$remove_wishlist_text = elgg_echo('remove:wishlish');
		$remove_wishlist_action = $CONFIG->wwwroot."action/{$CONFIG->pluginname}/remove_wishlist?__elgg_token=".generate_action_token($ts)."&__elgg_ts={$ts}";
		$rating = elgg_view("{$CONFIG->pluginname}/view_rating",array('id'=>$product->guid,'units'=>5,'static'=>''));
		if($product->status == 1){
			//$tell_a_friend = elgg_view("{$CONFIG->pluginname}/tell_a_friend",array('entity'=>$product));
			$not_available = "";
		}else{
			$not_available = "<div style='color:red;padding:5px 0;'>".elgg_echo('not:available')."</div>";
			$tell_a_friend = "";
		}
		if($stores->product_type_id == 1){
			if($stores->quantity > 0){
				$quantity = $stores->quantity;
			}else{
				$quantity = 0;
			}
			$quantity = "<span><B>{$quantity_text}:</B> {$quantity}</span>";
		}
		$display_total = get_price_with_currency($total);
		$entity_hidden .= elgg_view('input/securitytoken');
		$info .= <<<EOF
			<div class="storesqua_stores">
				<div style="margin:5px 0;">
					<span style="width:115px;float:left;display:block;"><B>{$price_text}:</B> {$display_total}</span>
					{$quantity}
					<div class="clear"></div>
				</div>
				<table>
					<tr>
					<td width="275px">
					</td>
						<td style="vertical-align:bottom;">
							<div class="wishlist_remove">
								<form name="frm_remove_wishlist{$product->guid}" method="post" action="{$remove_wishlist_action}">
									<a onclick="document.frm_remove_wishlist{$product->guid}.submit();" href="javascript:void(0)">{$remove_wishlist_text}</a>
									<input type="hidden" name="product_guid" value="{$product->guid}">
								</form>
							</div>
						</td>
					</tr>
				</table>
			</div>
			{$not_available}
EOF;
		$icon = elgg_view("{$CONFIG->pluginname}/image", array(
												'entity' => $product,
												'size' => 'small',
											  )
										);
		
		$display_cart_items .= elgg_view_listing($icon, $info);
	}
}else {
	$display_cart_items = elgg_echo('wishlist:null');
}
echo $display_cart_items
?>