<?php
	/**
	 * Elgg view - list view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 

	$stores = $vars['entity'];
	$action = get_input('action');
	$product_guid = $stores->getGUID();
	$tags = $stores->tags;
	$title = $stores->title;
	$desc = $stores->description;
	$ts = time();
	
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	$quantity_text = elgg_echo('quantity');
	$price_text = elgg_echo('price');
	$search_viewtype = get_input('search_viewtype');
	$mime = $stores->mimetype;
	$product_type_details = get_product_type_from_value($stores->product_type_id);
	if($stores->product_type_id == 1){
		if($stores->quantity > 0){
			$quantity = $stores->quantity;
		}else{
			$quantity = 0;
		}
		$quantity = "<span><B>{$quantity_text}:</B> {$quantity}</span>";
	}
	
	$info = "<p> <a href=\"{$stores->getURL()}\"><B>{$title}</B></a></p>";
	$info .= "<p class=\"owner_timestamp\">
		<a href=\"{$owner->getURL()}\">{$owner->name}</a> {$friendlytime}";
		$numcomments = elgg_count_comments($stores);
		if ($numcomments)
			$info .= ", <a href=\"{$stores->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
	$info .= "</p>";
	$tags_out =  elgg_view('output/tags',array('value' => $tags));
	$product_type_out =  elgg_view('output/product_type',array('value' => $stores->product_type_id));
	$category_out =  elgg_view('output/category',array('value' => $stores->category));
	$display_price = get_price_with_currency($stores->price);
	$info .= <<<EOF
		<div style="margin:5px 0;">
			<span style="width:115px;"><B>{$price_text}:</B> {$display_price}</span>
			<span>&nbsp;</span>
			{$quantity}
		</div>
		<table style="margin-top:3px;width:100%;">
			<tr>
				<td style="width:300px;" class="tag_td">
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

	$cart_url = addcartURL($stores);
	$cart_text = elgg_echo('add:to:cart');
	$wishlist_text = elgg_echo('add:wishlist');
	if($stores->status == 1){
		//$tell_a_friend = elgg_view("{$CONFIG->pluginname}/tell_a_friend",array('entity'=>$stores,'text'=>"display"));
		if($stores->owner_guid != $_SESSION['user']->guid && $product_type_details->addto_cart == 1){
			$wishlist_action = $CONFIG->wwwroot."action/{$CONFIG->pluginname}/add_wishlist?pgid=".$stores->guid."&__elgg_token=".generate_action_token($ts)."&__elgg_ts={$ts}";
			$cart_wishlist = <<<EOF
				<div class="cart_wishlist">
					<a title="{$cart_text}" class="cart" href="{$cart_url}">Add To Cart</a>
				</div>
				<div class="cart_wishlist">
					<a class="wishlist" href="{$wishlist_action}">{$wishlist_text}</a>
				</div>
EOF;
		}
	}
	$info .= <<<EOF
		<div class="storesqua_stores">
			<table style="width:100%;">
				<tr>
					<td>
						<div class="cart_wishlist" style="padding:5px 0 0 10px;">
							<div style="clear:both;"></div>
							<div class="cart_wishlist">
							</div>
							{$cart_wishlist}
							<div style="clear:both;"></div>	
						<div>
					</td>
				</tr>
			</table>
		</div>	
		
EOF;
	
	$image =  elgg_view("{$CONFIG->pluginname}/image", array(
									'entity' => $vars['entity'],
									'size' => 'small',
								  )
								);
	if($stores->mimetype && $stores->product_type_id == 2){							
		$icon = "<div style=\"padding-top:10px;\"><a href=\"{$stores->getURL()}\">" . elgg_view("{$CONFIG->pluginname}/icon", array("mimetype" => $mime, 'thumbnail' => $stores->thumbnail, 'stores_guid' => $product_guid, 'size' => 'small')) . "</a></div>";
	}
	echo elgg_view_listing($image.$icon, $info);
?>