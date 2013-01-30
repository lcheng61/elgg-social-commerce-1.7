<?php
	/**
	 * Elgg category - view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	 global $CONFIG;
	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		if(!isloggedin()){
			forward("pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username);
		}
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}

	//set Category title
		$title = elgg_view_title(elgg_echo('stores:category'));
		
	// Get objects
		$offset = 0;
		$limit = 9999;
		$fullview = false;
		set_context('search');
		$digital_cats = get_entities_from_metadata('product_type_id',2,"object","category",0,$limit);
		if($digital_cats){
			foreach($digital_cats as $digital_cat){
				$d_area .= elgg_view_entity($digital_cat,$fullview);
			}
			$digital_cate_text = elgg_echo('stores:digital');
			$digital_area = <<<EOF
				<div style="width:330px;display:block;">
					<div style="margin:10px 0;"><b>{$digital_cate_text}</b></div>
					{$d_area}
				</div>
EOF;
		}
		//$area2 .= list_entities("object","category",page_owner(),10);
		$area2 = <<<EOF
			{$title}
			<div class="contentWrapper stores" align="left">
				{$digital_area}
			</div>
EOF;
		set_context('category');
	// These for left side menu
		$area1 .= gettags();
		//$area1 .= get_storestype_cloud(page_owner());
	// Create a layout
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo("stores:category"),page_owner_entity()->name), $body);
	
?>