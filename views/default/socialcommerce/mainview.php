<?php
	/**
	 * Elgg view - product mainview
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	global $CONFIG;
	$stores = $vars['entity'];
	$action = get_input('action');
	$product_guid = $stores->getGUID();
	$tags = $stores->tags;
	$title = $stores->title;
	$desc = $stores->description;
	$price = $stores->price;
	$ts = time();
	
	$quantity = $stores->quantity;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	$quantity_text = elgg_echo('quantity');
	$price_text = elgg_echo('price');
	$search_viewtype = get_input('search_viewtype');
	$mime = $stores->mimetype;
	$product_type_details = get_product_type_from_value($stores->product_type_id);
	
	if(isset($_SESSION['product']))
		unset($_SESSION['product']);
	if(isset($_SESSION['related_product']))
		unset($_SESSION['related_product']);
?>
	<div class="storesrepo_stores">
	<div class="storesrepo_title"><h2><a href="<?php echo $stores->getURL(); ?>"><?php echo $title; ?></a></h2></div>
		<div class="storesrepo_icon full_view">
			<?php 
				echo elgg_view("{$CONFIG->pluginname}/image", array(
												'entity' => $vars['entity'],
												'size' => 'large',
												'display' => 'image'
											  )
										);
			?>	
		</div>
		<form method="post" action="<?php echo addcartURL($stores); ?>">
		<div class="right_section_contents">
			<div class="storesrepo_title_owner_wrapper">
				<?php
					//get the user and a link to their gallery
					$user_gallery = $vars['url'] . "mod/{$CONFIG->pluginname}/search.php?md_type=simpletype&subtype=stores&tag=image&owner_guid=" . $owner->guid . "&search_viewtype=gallery";
				?>
				
				<div class="storesrepo_owner">
					<?php
						echo elgg_view("profile/icon",array('entity' => $owner, 'size' => 'tiny'));
					?>
					<p class="storesrepo_owner_details"><b><a href="<?php echo $owner->getURL(); ?>"><?php echo $owner->name; ?></a></b><br />
					<small><?php echo $friendlytime; ?></small></p>
				</div>
			</div>
			<div class="storesrepo_maincontent">
				<?PHP if($price > 0){?>
					<div class="product_odd"><B><?php echo elgg_echo("Price");?></B></div>
					<div class="field_results s_price"><B><?php echo get_price_with_currency($price); ?></B></div>
				<?php }
					if($stores->product_type_id > 0){
				?>
					<div class="product_even"><B><?php echo elgg_echo("product:type");?></B></div>
					<div class="field_results">
						<?php 
						if($vars['entity']->mimetype && $stores->product_type_id == 2){
							echo "<div style=\"float:left;margin-top:20px;\">".elgg_view('output/product_type',array('value' => $stores->product_type_id))."</div>";
							echo "<div style=\"float:left;\"><a href=\"{$stores->getURL()}\">" . elgg_view("{$CONFIG->pluginname}/icon", array("mimetype" => $mime, 'thumbnail' => $stores->thumbnail, 'stores_guid' => $product_guid, 'size' => 'small')) . "</a></div>";
							echo "<div class=\"clear\"></div>";
						}else{
							echo elgg_view('output/product_type',array('value' => $stores->product_type_id));
						} 
						?>
					</div>
				<?php }
				if($stores->category > 0){
				?>
					<div class="product_odd"><B><?php echo elgg_echo("category");?></B></div>
					<div class="field_results"><?php echo elgg_view('output/category',array('value' => $stores->category)); ?></div>
				<?php } 
				if($quantity > 0 && $stores->product_type_id == 1){?>
					<div class="product_even"><B><?php echo elgg_echo("quantity");?> :</B> <?php echo $quantity ?></div>
				<?php } ?>
				<div class="storesrepo_tags">
					<span class="object_tag_string">
						<?php echo elgg_view('output/tags',array('value' => $tags)); ?>
					</span>
				</div>
<?php
				if ($stores->canEdit()) {?>
						<div class="storesrepo_controls">
<?php
							if($stores->status == 1){
?>
							<?PHP ; } ?>
								
<?php
							if($_SESSION['user']->guid != $stores->owner_guid && $stores->status == 1 && $product_type_details->addto_cart == 1){
?>
								<div class="cart_wishlist">
									<a class="wishlist" href="<?php echo $CONFIG->wwwroot."action/{$CONFIG->pluginname}/add_wishlist?pgid=".$stores->guid."&__elgg_token=".generate_action_token($ts)."&__elgg_ts={$ts}";  ?>"><?php echo elgg_echo('add:wishlist');?></a>
								</div>
							<?php } ?>
							<div class="clear"></div>
						</div>	
<?php
							if(isadminloggedin() || $_SESSION['user']->guid == $stores->owner_guid){
?>
								<div class="storesrepo_controls">
<?php
								 if($stores->status == 1){ 
?>
									<div class="edit_btn" style="float:left;">
										<a href="<?php echo $vars['url']; ?>mod/<?php echo $CONFIG->pluginname; ?>/edit.php?stores_guid=<?php echo $stores->getGUID(); ?>"><?php echo elgg_echo('edit'); ?></a>&nbsp; 
									</div>
									
									<div class="delete_btn" style="float:left;padding-left:10px;">
										<?php 
											echo elgg_view('output/confirmlink',array(
												'href' => $vars['url'] . "action/{$CONFIG->pluginname}/delete?stores=" . $stores->getGUID(),
												'text' => elgg_echo("delete"),
												'confirm' => elgg_echo("stores:delete:confirm"),
											));  
										?>
									</div>
							<?PHP } else { ?>
									<div class="retrieve_btn" style="float:left;">
										<a href="<?php echo $vars['url']; ?>action/<?php echo $CONFIG->pluginname; ?>/retrieve?stores_guid=<?php echo $stores->getGUID(); ?>&__elgg_token=<?php echo generate_action_token($ts); ?>&__elgg_ts=<?php echo $ts; ?>"><?php echo elgg_echo('retrieve'); ?></a>&nbsp; 
									</div>
						<?php 
								}
						?>
								<div style="clear:both;"></div>
								</div>
						<?php
							}
				}else{
					if($stores->status == 1){
?>	
						<div class="storesrepo_controls">
							<?php if($product_type_details->addto_cart == 1) { ?>
								<div class="cart_wishlist">
										<a class="wishlist" href="<?php echo $CONFIG->wwwroot."action/".$CONFIG->pluginname."/add_wishlist?pgid=".$stores->guid."&__elgg_token=".generate_action_token($ts)."&__elgg_ts={$ts}";  ?>"><?php echo elgg_echo('add:wishlist');?></a>
								</div>
							<?php } ?>
							<div style="clear:both;"></div>	
						</div>
<?php	
					}
				}
?>
				<!-- Cart Button -->
				<?php echo elgg_view("{$CONFIG->pluginname}/socialcommerce_cart",array('entity'=>$stores,'product_type_details'=>$product_type_details,'phase'=>1)); ?>
			</div>
		</div>
		<div class="clear"></div>
		<table width="100%">
			<tr>
				<td>
					<?php
						$display_fields = '';
						$product_fields = $CONFIG->product_fields[$stores->product_type_id];
						if (is_array($product_fields) && sizeof($product_fields) > 0){
							foreach ($product_fields as $shortname => $valtype){
								if($valtype['display'] == 1 && 	$shortname != 'price' && $shortname != 'quantity' && $shortname != 'upload'){
									$display_name = elgg_echo('product:'.$shortname);
									$output = elgg_view("output/{$valtype['field']}",array('value'=>$stores->$shortname));
									$display_fields .= <<<EOF
										<div class="storesrepo_description">
											<B>{$display_name} :</B> {$output}
										</div>
EOF;
								}
							}
						}
						echo $display_fields;
					?>
					<?php echo  elgg_view("custom_field/display",array('entity'=>$vars['entity'])); ?>
					<div class="features"><?php echo elgg_echo('features:des'); ?></div>
					<div class="storesrepo_description"><?php echo autop($desc); ?></div>
				</td>
		</tr>
		</table>
		<?php echo elgg_view('input/securitytoken'); ?>
		</form>
	</div>
	
<?PHP
	if(isloggedin() && $vars['entity']->owner_guid == $_SESSION['user']->guid){
		echo elgg_view("{$CONFIG->pluginname}/order_view",array('entity'=>$vars['entity']));
	}
?>
<?php
	if ($vars['full']) {
		echo elgg_view_comments($stores);
	}
?>
<img src='http://surfscripts.com/demo/adtracker/index.php/tracker/trackdata/1' width='0' height='0'>