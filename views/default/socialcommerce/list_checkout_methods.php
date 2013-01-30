<?php
	/**
	 * Elgg view - list checkout methods
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 

	global $CONFIG;
	
	$settings = get_entities('object','splugin_settings',0,'',9999);
	if($settings){
		$selected_checkout_methods = $settings[0]->checkout_methods;
		if(!is_array($selected_checkout_methods))
			$selected_checkout_methods = array($selected_checkout_methods);
		$checkout_methods = get_checkout_methods();
		$action = $CONFIG->checkout_base_url."pg/{$CONFIG->pluginname}/".$_SESSION['user']->username."/checkout_process/";
		$checkout_method_validation_text = elgg_echo('checkout:method:validation:text');
		$checkout_method_title_text = elgg_echo('checkout:method:title:text');
		$method_display = <<<EOF
			<script type="text/javascript">
				function checkout_method_validation(){
					if ($("input[name='checkout_method']").is(':checked')){
						return true;
					}else{
						alert("{$checkout_method_validation_text}");
						return false;
					}
				}
			</script>
			<div style='padding:10px 5px;'>
				<B>{$checkout_method_title_text}</B>
			</div>
			<form onsubmit="javascript:return checkout_method_validation();" name='checkout_method_selection' method='post' action='{$action}'>
EOF;
		$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('checkout:select:checkout:method')));
		$i = 1;
		foreach ($selected_checkout_methods as $selected_checkout_method){
			if($i == 1 && empty($_SESSION['CHECKOUT']['checkout_method'])){
				$checked = "checked='checked'";
			}else{
				$checked = "";
			}
			if($selected_checkout_method == $_SESSION['CHECKOUT']['checkout_method']){
				 $checked = "checked='checked'";
			}
			
			$i++;
			$method_display .= <<<EOF
				<div style='padding:5px;'>
					<input type='radio' name='checkout_method' value='{$selected_checkout_method}' {$checked}> 
					<span style='margin-left:5px;'>{$checkout_methods[$selected_checkout_method]->label}</span>
				</div>
EOF;
		}
		$method_display .= <<<EOF
				<div>
					{$submit_input}
					<input type="hidden" name="checkout_order" value="1">
				</div>
			</form>
EOF;
	}else{
		$method_display = elgg_echo('checkout:checkout:method:no:settings');	
	}
	echo $method_display;
?>