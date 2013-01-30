<?php
	/**
	 * Elgg view - icon
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	// Get engine
		require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");
		//echo dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php";
	global $CONFIG;
	
	$mime = $vars['mimetype'];
	if (isset($vars['thumbnail'])) {
		$thumbnail = $vars['thumbnail'];
	} else {
		$thumbnail = false;
	}
	
	$size = $vars['size'];
	if ($size != 'large') {
		$size = 'small';
	}
	//echo "<a href=\"{$vars['url']}action/stores/icon?stores_guid={$vars['stores_guid']}\">hai</a>";
	// Handle 
	switch ($mime)
	{
		case 'image/jpg' 	:
		case 'image/jpeg' 	:
		case 'image/png' 	:
		case 'image/gif' 	:
		case 'image/bmp' 	: 
			if ($thumbnail) {
				if ($size == 'small') {
					echo "<img src=\"{$vars['url']}action/{$CONFIG->pluginname}/icon?stores_guid={$vars['stores_guid']}&mimetype={$mime}\" border=\"0\" />";
				} else {
					echo "<img src=\"{$vars['url']}mod/{$CONFIG->pluginname}/thumbnail.php?stores_guid={$vars['stores_guid']}&mimetype={$mime}\" border=\"0\" />";
				}
				
			} else 
			{
				if ($size == 'large') {
					echo "<img src=\"{$CONFIG->wwwroot}mod/{$CONFIG->pluginname}/graphics/icons/general_lrg.gif\" border=\"0\" />";
				} else {
					echo "<img src=\"{$CONFIG->wwwroot}mod/{$CONFIG->pluginname}/graphics/icons/general.gif\" border=\"0\" />";
				}
			}
			
		break;
		default : 
			if (!empty($mime) && elgg_view_exists("{$CONFIG->pluginname}/icon/{$mime}")) {
				echo elgg_view("{$CONFIG->pluginname}/icon/{$mime}", $vars);
			} else if (!empty($mime) && elgg_view_exists("{$CONFIG->pluginname}/icon/" . substr($mime,0,strpos($mime,'/')) . "/default")) {
				echo elgg_view("{$CONFIG->pluginname}/icon/" . substr($mime,0,strpos($mime,'/')) . "/default");
			} else {
				echo "<img src=\"{$CONFIG->wwwroot}mod/{$CONFIG->pluginname}/graphics/icons/general.gif\" border=\"0\" />";
			}	 
		break;
	}

?>