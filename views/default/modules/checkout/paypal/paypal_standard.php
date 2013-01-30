<?php
	/**
	 * Elgg checkout - paypal - view page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/ 
	 
	global $CONFIG;
	$method = $vars['method'];
	$base = $vars['base'];
	$settings = get_entities_from_metadata('checkout_method','paypal','object','s_checkout',0,1);
	if($settings){
		$settings = $settings[0];	
	}
	$order = $vars['order'];
	$action = $CONFIG->wwwroot."action/".$CONFIG->pluginname."/manage_socialcommerce";
	$method_view = $method->view;
	$display_name = $settings->display_name;
	if(empty($display_name))
		$display_name = $method->label;
	$stores_paypal_email = $settings->socialcommerce_paypal_email;
	$paypal_environment = $settings->socialcommerce_paypal_environment;
	if(!$paypal_environment)
		$paypal_environment = $base;
?>
<div>
	<div>
		<?php echo elgg_echo('paypal:instructions'); ?>
	</div>
	<div>
		<ul>
			<li><?php echo sprintf(elgg_echo('paypal:instruction1'),'https://www.paypal.com/us/cgi-bin/webscr?cmd=_registration-run'); ?></li>
		   	<li><?php echo elgg_echo('paypal:instruction2'); ?></li>
		</ul>
	</div>
	<div>
		<h4><?php echo elgg_echo('settings'); ?></h4>
		<div>
			<form method="post" action="<?php echo $action; ?>">
				<table class="stores_settings" width="50%" style="float:left;">
					<tr>
						<td style="text-align:right;"><B><span style="color:red;">*</span> <?php echo elgg_echo('display:name'); ?></B></td>
						<td>:</td>
						<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'display_name','value'=>$display_name)); ?></td>
					</tr>
					<tr>
						<td style="text-align:right;"><B><span style="color:red;">*</span> <?php echo elgg_echo('paypal:email'); ?></B></td>
						<td>:</td>
						<td style="text-align:left;"><?php echo elgg_view('input/text',array('internalname'=>'socialcommerce_paypal_email','value'=>$stores_paypal_email)); ?></td>
					</tr>
					<tr>
						<td style="text-align:right;">
							<B><span style="color:red;">*</span> <?php echo elgg_echo('mode'); ?></B>
						</td>
						<td>:</td>
						<td style="text-align:left;">
							<input type="radio" name="socialcommerce_paypal_environment" value="paypal" <?php if($paypal_environment == "paypal"){ echo "checked = 'checked'";} ?> class="input-radio" />
							<B><?php echo elgg_echo('stores:paypal'); ?></B>
							&nbsp;
							<input type="radio" name="socialcommerce_paypal_environment" value="sandbox" <?php if($paypal_environment == "sandbox"){ echo "checked = 'checked'";} ?> class="input-radio" />
							<B><?php echo elgg_echo('stores:sandbox'); ?></B>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td style="text-align:left;">
							<input type='submit' name='btn_submit' value='<?php echo elgg_echo('stores:save'); ?>'>
							<input type='hidden'"' name='method' value="<?php echo $base; ?>">
							<input type='hidden'"' name='manage_action' value="checkout">
							<input type='hidden'"' name='guid' value="<?php echo $settings->guid; ?>">
							<input type='hidden'"' name='order' value="<?php echo $order; ?>">
							<?php echo elgg_view('input/securitytoken'); ?>
						</td>
					</tr>
				</table>
				<div style="float:left;margin:18px 0 0 20px;">
					<img src="<?php echo $CONFIG->wwwroot; ?>mod/<?php echo $CONFIG->pluginname; ?>/views/default/modules/checkout/paypal/images/paypal_logo.gif">
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>