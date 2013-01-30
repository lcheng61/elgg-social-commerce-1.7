<?php
	/**
	 * Elgg product - type change
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	global $CONFIG;
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	$product_type_id = get_input('pt');
	$action = get_input('at');
	$product_id = get_input('id');
	if($product_id){
		$product = get_entity($product_id);
	}
	
	if($action == 'get_category'){
		$category_lists = get_entities_from_metadata("product_type_id",$product_type_id,"object","category",0,99999);
		$options_values = array();
		if($category_lists){
			foreach ($category_lists as $category_list){
				$options_values[$category_list->guid] = $category_list->title;
			}	
		}
		$category_label = elgg_echo('category');
		if(!empty($category_lists)){
			$category = elgg_view('input/pulldown', array('internalname' => 'storescategory', 
													  'value' => "$category", 
													  'options_values' => $options_values));
		}else{
			$category = elgg_echo('no:category');	
		}
		
		$body = <<<EOF
			<p>
				<label><span style="color:red">*</span>$category_label</label><br />
				{$category}
			</p>
EOF;
		echo $body;
	}elseif ($action == 'get_fields'){
		$cstom_fields = elgg_view("custom_field/view",array('entity'=>$product,'entity_type'=>$product_type_id));
		$fields = '';
		$product_fields = $CONFIG->product_fields[$product_type_id];
		if (is_array($product_fields) && sizeof($product_fields) > 0){
			foreach ($product_fields as $shortname => $valtype){
				$value = $product->$shortname;
				if(elgg_echo('product:'.$shortname) == elgg_echo('product:price') || elgg_echo('product:'.$shortname) == elgg_echo('product:quantity')){
					$mandatory = '<span style="color:red">*</span>';
				}else{
					$mandatory = '';
				}
				$fields .= '<p><label>'.$mandatory .elgg_echo('product:'.$shortname).'</label><br />';
				if($product->mimetype != "" && $shortname == 'upload' && $valtype['field'] == 'file'){
					$fields .= elgg_view("{$CONFIG->pluginname}/icon", array("mimetype" => $product->mimetype, 'thumbnail' => $product->thumbnail, 'file_guid' => $product->guid));
				}else{
					$fields .= elgg_view("input/{$valtype['field']}",array(
															'internalname' => $shortname,
															'value' => $value,
															));
				}
				$fields .= '</p>';
	
			}
		}
		echo $fields.$cstom_fields;
	}
?>