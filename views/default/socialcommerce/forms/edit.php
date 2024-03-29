<?php
	/**
	 * Elgg form - product
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	global $CONFIG;

	
	
	
	// Set title, form destination
		if (isset($vars['entity'])) {
			$title = sprintf(elgg_echo("stores:editpost"),$object->title);
			$action = "{$CONFIG->pluginname}/edit";
			$title = $vars['entity']->title;
			$body = $vars['entity']->description;
			$taxrate_name_cnty = $vars['entity']->countrycode;
			$price = $vars['entity']->price;
			$base_stock = $vars['entity']->base_stock;
			$category = $vars['entity']->category;
			$quantity = $vars['entity']->quantity;
			$tags = $vars['entity']->tags;
			$access_id = $vars['entity']->access_id;
			$product_type_id = $vars['entity']->product_type_id;
			if($product_type_id <= 0)
				$product_type_id = 2;
		} else  {
			$title = elgg_echo("stores:addpost");
			$action = "{$CONFIG->pluginname}/add";
			$tags = "";
			$title = "";
			$body = "";
			$base_stock = "";
			$access_id = 2;
			$product_type_id = 2;
		}

	// Just in case we have some cached details
		if (isset($vars['product'])) {
			//unset($_SESSION['product']);
			$title = $vars['product']['storestitle'];
			$product_type_id = $vars['product']['product_type_id'];
			$category = $vars['product']['storescategory'];
			$body = $vars['product']['storesbody'];
			$tags = $vars['product']['storestags'];
			$access_id = $vars['product']['access_id'];
			
			$product_fields = $CONFIG->product_fields[$product_type_id];
			if (is_array($product_fields) && sizeof($product_fields) > 0){
				foreach ($product_fields as $shortname => $valtype){
					if($valtype['field'] != 'file')
						$_SESSION['product'][$shortname] = get_input($shortname);
				}
			}
			
			$price = $vars['product']['price'];
			$base_stock = $vars['product']['base_stock'];
			$quantity = $vars['product']['quantity'];
			
			
		}
		$chk_tax_type = '';
		$country_details = '';
		$splugin_settings = get_entities('object','splugin_settings');

?>

<?php

        $title_label = elgg_echo('title');
        $title_textbox = elgg_view('input/text', array('internalname' => 'storestitle', 'value' => $title));
        
        $produt_type = elgg_view('input/product_type', array('internalname' => 'product_type_id', 'value' => $product_type_id));
        
        $category_lists = get_entities_from_metadata("product_type_id",$product_type_id,"object","category",0,99999);
        $options_values = array();
        if($category_lists){
        	foreach ($category_lists as $category_list){
        		$options_values[$category_list->guid] = $category_list->title;
        	}	
        }
        
        $country_name = elgg_echo('country');
        $country_label = "<label><span style='color:red'>*</span>{$country_name}</label><br />";
        $country_list = "<select name='tax_country' id='tax_country' >";
            if($CONFIG->country){
			foreach ($CONFIG->country as $country){
				if($taxrate_name_cnty == $country['iso3']){
					$selected = "selected";
				}else {
					$selected = "";
				}
				$country_list .= "<option value='".$country['iso3']."' ".$selected.">".$country['name']."</option>";
			}	
		}
        $country_list .= "</select>";

	
							
        $category_label = elgg_echo('category');
        if(!empty($category_lists)){
			$category_view = elgg_view('input/pulldown', array('internalname' => 'storescategory', 
													  'value' => "$category", 
													  'js' => "id='storescategory'", 
													  'options_values' => $options_values));
        }else{
        	$category_view = elgg_echo('no:category');	
        }
        if (($action == "{$CONFIG->pluginname}/add" && $product_type_id == 2 && $vars['entity']->mimetype == "")||($vars['entity']->guid > 0 && $product_type_id == 2 && $vars['entity']->mimetype == "")) {
			$upload_label = elgg_echo('stores:file');
	        $upload_input = elgg_view("input/file",array('internalname' => 'upload'));
			$form_upload = <<<EOT
				<p>
					<label><span style="color:red">*</span>$upload_label</label><br />
		                        $upload_input
				</p>
EOT;
		}elseif ($vars['entity']->guid > 0 && $product_type_id == 2  && $vars['entity']->mimetype != ""){
			$upload_label = elgg_echo('stores:file');
			$upload_input = elgg_view("{$CONFIG->pluginname}/icon", array("mimetype" => $vars['entity']->mimetype, 'thumbnail' => $vars['entity']->thumbnail, 'file_guid' => $vars['entity']->guid));
			$form_upload = <<<EOT
				<p>
					<label><span style="color:red">*</span>$upload_label</label><br />
		                        $upload_input
				</p>
EOT;
		}
		if ($vars['entity']->guid > 0){
			$uploaded_image = elgg_view("{$CONFIG->pluginname}/image", array(
										'entity' => $vars['entity'],
										'size' => 'small',
										'display'=>'image'
									  )
								);
		}
        
        $image_label = elgg_echo('product:image');
        $image_input = elgg_view("input/file",array('internalname' => 'product_image'));
        
        $text_label = elgg_echo('stores:text');
        $text_textarea = elgg_view('input/longtext', array('internalname' => 'storesbody', 'value' => $body));
        
        $fields = '';
		$product_fields = $CONFIG->product_fields[2];
		if (is_array($product_fields) && sizeof($product_fields) > 0){
			foreach ($product_fields as $shortname => $valtype){
				$value = $vars['entity']->$shortname;
				if (isset($vars['product']))
					$value = $vars['product'][$shortname];
				if($valtype['mandatory'] == 1){
					$mandetory = '<span style="color:red">*</span>';	
				}else{
					$mandetory = '';	
				}
				$fields .= '<p><label>'.$mandetory.elgg_echo('product:'.$shortname).'</label><br />';
				if($vars['entity']->mimetype != "" && $shortname == 'upload' && $valtype['field'] == 'file'){
					$fields .= "<div style='float:left;'>".elgg_view("{$CONFIG->pluginname}/icon", array("mimetype" => $vars['entity']->mimetype, 'thumbnail' => $vars['entity']->thumbnail, 'stores_guid' => $vars['entity']->guid))."</div>";
					$fields .= "<div class='change_product_file'><a href='javascript:void(0);' onclick='load_edit_product_detaile();'><b>".elgg_echo('product:edit:file')."</a></a></div><div class='clear'></div>";
					$fields .= "<div id='product_file_change'>".elgg_view("input/{$valtype['field']}",array(
															'internalname' => $shortname,
															'value' => $value,
															)).'</div>';
				}else {
					$fields .= elgg_view("input/{$valtype['field']}",array(
															'internalname' => $shortname,
															'value' => $value,
															));
				}
				$fields .= '</p>';
			}
		}
        
        $tag_label = elgg_echo('tags');
        $tag_input = elgg_view('input/tags', array('internalname' => 'storestags','value' => $tags));
        
        $access_label = elgg_echo('access');
        $access_input = elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
        
        $submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('save')));

        if (isset($vars['container_guid']))
			$entity_hidden = "<input type=\"hidden\" name=\"container_guid\" value=\"{$vars['container_guid']}\" />";
		if (isset($vars['entity']))
			$entity_hidden .= "<input type=\"hidden\" name=\"stores_guid\" id=\"stores_guid\" value=\"{$vars['entity']->getGUID()}\" />";
			
		$entity_hidden .= elgg_view('input/securitytoken');
		$post_url = $CONFIG->wwwroot."mod/{$CONFIG->pluginname}/onchange_product_type.php";
		if(!$vars['entity']->guid)
			$id = 0;
		else 
			$id = $vars['entity']->guid;
		
		$cstom_fields = elgg_view("custom_field/view",array('entity'=>$vars['entity'],'entity_type'=>$product_type_id));
        $form_body = <<<EOT
        	<script>
        		
        		function load_edit_product_detaile(){
					 $("#product_file_change").show();
				}
        	</script>
        	<form action="{$vars['url']}action/{$action}" enctype="multipart/form-data" method="post">
				<p>
					<label><span style="color:red">*</span>{$title_label}</label><br />
					{$title_textbox}
				</p>
				{$produt_type}
				<div id="change_by_product_type">
					<p>
						<label><span style="color:red">*</span>{$category_label}</label><br />
						{$category_view}
					</p>
				</div>
				<p>
					{$country_details}
				</p>
				<p>
					<label><span style="color:red">*</span>{$text_label}</label><br />
					{$text_textarea}
				</p>
				<p>
					<label><span style="color:red"></span>{$image_label}</label><br />
					{$image_input}{$uploaded_image}
				</p>
				<div id="product_type_fields">
					{$fields}
					{$cstom_fields}
				</div>
				<p>
					<label>{$tag_label}</label><br />
					{$tag_input}
				</p>
				<p>
					<label>{$access_label}</label><br />
					{$access_input}
				</p>
				<p>
					{$entity_hidden}
					{$submit_input}
				</p>
			</form>
EOT;
echo $form_body;
?>