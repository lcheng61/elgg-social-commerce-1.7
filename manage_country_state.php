<?php
	/**
	 * Elgg address - view and reload addresses
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	// Load Elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	global $CONFIG;
	
	$type = get_input('type');
	if($type == "shipping")
		$checkout_order = 1;
	else 
		$checkout_order = 0;
	
	$todo = get_input('todo');
	$class = get_input('class');
	switch ($todo){
		case 'load_state':
			$country = get_input('country');
			if(strlen($country) == 2){
				$field = 'iso2';
			}elseif(strlen($country) == 3){
				$field = 'iso3';
			}
			$states = get_state_by_fields($field,$country);
			if(!empty($states)){
				$state_list = '<select name="state" id="'.$type.'_state" class="'.$class.'">';
				foreach ($states as $state){
					if($selected_state == $state->name){
						$selected = "selected";
					}else{
						$selected = "";
					}
					$state_list .= "<option value='" . $state->name . "' " . $selected . ">" . $state->name . "</option>";
				}
				$state_list .= '</select>';
			}else{
				$state_list = '<input class="'.$class.' input-text" type="text" value="'.$selected_state.'" id="'.$type.'_state" name="state"/>';
			}
			echo $state_list;
			break;
	}
?>