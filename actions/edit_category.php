<?php
	/**
	 * Elgg category - edit action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
	 **/ 

	global $CONFIG;
	
	// Get variables
	$title = trim(get_input("categorytitle"));
	$product_type_id = trim(get_input("product_type_id"));
	$desc = get_input("categorybody");
	
	$guid = (int) get_input('category_guid');
	
	if (!$category = get_entity($guid)) {
		register_error(elgg_echo("category:addfailed"));
		forward($CONFIG->wwwroot . "pg/{$CONFIG->pluginname}/" . $_SESSION['user']->username . "/category/");
		exit;
	}
	
	$result = false;
	//Validation
	if(empty($title)){
		$error_field = elgg_echo("title");
	}
	if(empty($product_type_id) || $product_type_id <=0){
		$error_field = elgg_echo("product:type");
	}
	$container_guid = $category->container_guid;
	$container = get_entity($container_guid);
	if(!empty($error_field)){
		$_SESSION['category']['categorytitle'] = $title;
		$_SESSION['category']['categorybody'] = $desc;
		$_SESSION['category']['product_type_id'] = $product_type_id;
		
		register_error(sprintf(elgg_echo("product:validation:null"),$error_field));
		$container_user = get_entity($container_guid);
		$redirect = $CONFIG->wwwroot . "mod/{$CONFIG->pluginname}/edit_category.php?category_guid=".$guid;
	}else{
		if ($category->canEdit()) {
		
			$category->access_id = 2;
			$category->title = $title;
			$category->product_type_id = $product_type_id;
			$category->description = $desc;
			
			$result = $category->save();
		}
		
		if ($result){
			system_message(elgg_echo("category:saved"));
			unset($_SESSION['category']);
		}else{
			register_error(elgg_echo("category:addfailed"));
		}
		
		$container_user = get_entity($container_guid);
		$redirect = $CONFIG->wwwroot . "pg/{$CONFIG->pluginname}/" . $container_user->username . "/category/";
	}
	forward($redirect);
?>