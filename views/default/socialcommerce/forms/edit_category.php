<?php
	/**
	 * Elgg form - category
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
			$title = sprintf(elgg_echo("stores:editcate"),$object->title);
			$action = "{$CONFIG->pluginname}/edit_category";
			$title = $vars['entity']->title;
			$product_type_id = $vars['entity']->product_type_id;
			$body = $vars['entity']->description;
		} else {
			$title = elgg_echo("stores:addcate");
			$action = "{$CONFIG->pluginname}/add_category";
			$title = "";
			$body = "";
			$access_id = 2;
			$product_type_id = 1;
		}

	// Just in case we have some cached details
		if (isset($vars['category']['categorytitle'])) {
			$title = $vars['category']['categorytitle'];
			$body = $vars['category']['categorybody'];
			$product_type_id = $vars['category']['product_type_id'];
		}

?>

<?php
                $title_label = elgg_echo('title');
                $title_textbox = elgg_view('input/text', array('internalname' => 'categorytitle', 'value' => $title));
                
                $produt_type = elgg_view('input/product_type', array('internalname' => 'product_type_id', 'value' => $product_type_id));
                
               
$text_label = elgg_echo('category:text');
                $text_textarea = elgg_view('input/longtext', array('internalname' => 'categorybody', 'value' => $body));
                
                $submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('save:category')));

                if (isset($vars['container_guid']))
					$entity_hidden = "<input type=\"hidden\" name=\"container_guid\" value=\"{$vars['container_guid']}\" />";
				if (isset($vars['entity']))
					$entity_hidden .= "<input type=\"hidden\" name=\"category_guid\" value=\"{$vars['entity']->getGUID()}\" />";
				
				$entity_hidden .= elgg_view('input/securitytoken');	
				$form_body = <<<EOT
                	<form action="{$vars['url']}action/{$action}" enctype="multipart/form-data" method="post">
						<p>
							<label><span style="color:red">*</span> $title_label</label><br />
				                        $title_textbox
						</p>
						{$produt_type}
						<p>
							<label>$text_label</label><br />
				                        $text_textarea
						</p>
						<p>
							$entity_hidden
							$submit_input
						</p>
					</form>
EOT;
echo $form_body;
?>