<?php
	/**
	 * Elgg category - delete action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
	 **/
		global $CONFIG;
		$guid = (int) get_input('category');
		if ($category = get_entity($guid)) {

			if ($category->canEdit()) {

				$container = get_entity($category->container_guid);
				
				if (!$category->delete()) {
					register_error(elgg_echo("category:deletefailed"));
				} else {
					system_message(elgg_echo("category:deleted"));
				}

			} else {
				
				$container = $_SESSION['user'];
				register_error(elgg_echo("category:deletefailed"));
				
			}

		} else {
			
			register_error(elgg_echo("category:deletefailed"));
			
		}
		
		forward("pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username . "/category/");

?>