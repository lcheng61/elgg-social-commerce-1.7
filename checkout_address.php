<?php
	/**
	 * Elgg address - checkout view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/ 

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	global $CONFIG;
	$address = (int) get_input('guid');
	$title = elgg_view_title(elgg_echo('address:edit'));
	if ($address = get_entity($address)) {
		$area2 = elgg_view("{$CONFIG->pluginname}/forms/edit_address",array('entity' => $address,'ajax'=>1));
    } else {
		$area2 = elgg_view("{$CONFIG->pluginname}/forms/edit_address",array('ajax'=>1));
	}
	echo $area2;
	
?>