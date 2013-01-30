<?php
	/**
	 * Elgg add product entry page
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/

	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		gatekeeper();
		global $CONFIG;
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
		$container_guid = page_owner();
	//set the title
		$area2 = elgg_view_title(elgg_echo('stores:addpost'));

	// Get the form
		$area2 .= "<div class=\"contentWrapper\">".elgg_view("{$CONFIG->pluginname}/forms/edit")."</div>";
		
	// These for left side menu
		$area1 .= gettags();
		
	// Get the body
		$body = elgg_view_layout("two_column_left_sidebar", $area1, $area2);	
			
	// Display page
		page_draw(elgg_echo('stores:addpost'),$body);

		
?>