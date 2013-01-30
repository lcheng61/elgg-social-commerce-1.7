<?php
	/**
	 * Elgg product - reload action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
	 **/ 
	global $CONFIG;
	$guid = (int) get_input('stores_guid');
	if ($stores = get_entity($guid)) {

		if ($stores->canEdit()) {
			$stores->status = 1;
			$context = get_context();
			set_context('retrive_product');
			$retrieve = $stores->save();
			set_context($context);
			if (!$retrieve) {
				register_error(elgg_echo("stores:retrievefailed"));
			} else {
				system_message(elgg_echo("stores:retrieved"));
			}

		} else {
			
			$container = $_SESSION['user'];
			register_error(elgg_echo("stores:retrievefailed"));
			
		}

	} else {
		
		register_error(elgg_echo("stores:retrievefailed"));
		
	}
	
	forward("pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username);

?>