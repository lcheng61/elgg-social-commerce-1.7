<?php
	/**
	 * Elgg product - download action
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
	 **/ 
	
	global $CONFIG;
	// Get the guid
	$order_guid = get_input("product_guid");
	
	$order = get_entity($order_guid);
	$subtype = get_data_row("SELECT * from {$CONFIG->dbprefix}entity_subtypes where id='{$order->subtype}'");
	
	if(isloggedin() && $order && $subtype->subtype == "order_item" && $order->owner_guid == $_SESSION['user']->guid){
		// Get the file
		$product = get_entity($order->product_id);
		
		if ($product){	
			
			$prod = new ElggFile();	
			$prod->guid = $product->guid;
			$prod->owner_guid = $product->owner_guid;
			$prod->container_guid = $product->container_guid;
			$prod->mimetype = $product->mimetype;
			$prod->originalfilename = $product->originalfilename;
			$prod->filename = $product->filename;
			$prod->simpletype = $product->simpletype;
			$prod->site_guid = $product->site_guid;
			$prod->access_id = $product->access_id;
			$prod->time_created = $product->time_created;
			$prod->time_updated = $product->time_updated;
			$prod->title = $product->title;
			$prod->description = $product->description;
			$prod->tables_split = $product->tables_split;
			$prod->tables_loaded = $product->tables_loaded;
			
			$mime = $prod->getMimeType();
			if (!$mime) $mime = "application/octet-stream";
			
			$filename = $product->originalfilename;
			
			header("Content-type: $mime");
			if (strpos($mime, "image/")!==false)
				header("Content-Disposition: inline; filename=\"$filename\"");
			else
				header("Content-Disposition: attachment; filename=\"$filename\"");
				
		 	
	
			$contents = $prod->grabFile();
			$splitString = str_split($contents, 8192);
			foreach($splitString as $chunk)
				echo $chunk;
			exit;
		}
	}
	else
		register_error(elgg_echo("file:downloadfailed"));
?>