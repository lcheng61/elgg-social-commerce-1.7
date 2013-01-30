<?php
	/**
	 * Elgg view - tags menu
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	global $CONFIG;
	$tags = $vars['tags'];
	
	if (is_array($vars['tags']) && sizeof($vars['tags'])) {
		$all = "all";
		$vars['tags'][] = $all;
		$vars['tags'] = array_reverse($vars['tags']);
		foreach($vars['tags'] as $tag) {print_r($tagarr);

			if ($tag != "all") {
				$label = elgg_echo($tag);
			} else {
				$label = elgg_echo('all');
			}
			
			$url = $vars['url'] . "mod/{$CONFIG->pluginname}/search.php?subtype=stores";
			if ($tag != "all")
				$url .= "&md_type=simpletype&tag=" . urlencode($tag);
				
			$inputtag = get_input('tag');
			if ($inputtag == $tag || (empty($inputtag) && $tag == "all")) {
				$class = " class=\"selected\" ";
			} else {
				$class = "";
			}
				
			$submenu .= add_submenu_item($label, $url, 'stores_tag');
		}
	}
?>