<?php
	/**
	 * Elgg view - over write owner block
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	global $CONFIG;

	if(isloggedin()){
?>
		<div id="owner_block_stores">
			<?php if (isadminloggedin()) { ?>
				<!--My Account-->
				<div class="scommerce_settings">
					<a href="<?php echo $CONFIG->wwwroot . 'pg/'.$CONFIG->pluginname.'/' . $_SESSION['user']->username . '/settings'; ?>" />
						<?php echo elgg_echo('socialcommerce:settings'); ?>
					</a>
				</div>
			<? } ?>
			<!--My Account-->
			<div class="my_account">
				<a href="<?php echo $CONFIG->checkout_base_url ?>pg/<?php echo $CONFIG->pluginname; ?>/<?php echo $_SESSION['user']->username; ?>/my_account" />
					<?php echo elgg_echo('stores:my:account'); ?>
				</a>
			</div>
			<?php 
			if(!isadminloggedin()){
			?>
			<!--Cart-->
			<?php 
				if($CONFIG->cart_item_count){
					$c_count = " (".$CONFIG->cart_item_count.")";
				}
			?>
			<div class="cart">
				<a href="<?php echo $CONFIG->wwwroot ?>pg/<?php echo $CONFIG->pluginname; ?>/<?php echo $_SESSION['user']->username; ?>/cart" />
					<?php echo elgg_echo('stores:my:cart').$c_count; ?>
				</a>
			</div>
			<!--Wishlist-->
			<?php 
				if($CONFIG->wishlist_item_count){
					$w_count = " (".$CONFIG->wishlist_item_count.")";
				}
			?>
			<div class="wishlist">
				<a href='<?php echo $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username . "/wishlist"; ?>' />
					<?php echo elgg_echo('stores:my:wishlist').$w_count ?>
				</a>
			</div>
			<!--orders-->
			<div class="orders">
				<a href='<?php echo $CONFIG->wwwroot."pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username . "/order/"; ?>' />
					<?php echo elgg_echo('stores:my:order') ?>
				</a>
			</div>
			<?php 
			}
			?>
		</div>
<?php
	}else{
		if($CONFIG->cart_item_count){
			$c_count = " (".$CONFIG->cart_item_count.")";
?>
		<div id="owner_block_stores">
			<!--Cart-->
			<div class="cart">
				<a href="<?php echo $CONFIG->wwwroot ?>pg/<?php echo $CONFIG->pluginname; ?>/gust/cart" />
					<?php echo elgg_echo('stores:gust:cart').$c_count; ?>
				</a>
			</div>
		</div>
<?php
		}
	}
?>