<?php
	/**
	 * Elgg input - product type
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/  
	 
	if (isset($vars['class'])) 
		$class = $vars['class'];
		
	if (!$class) $class = "input-product-type";
	
	if (!array_key_exists('value', $vars))
		$vars['value'] = 1;

	$default_produt_types = $CONFIG->produt_type_default;
	$produt_type_label = elgg_echo('product:type');
 	if (is_array($default_produt_types) && sizeof($default_produt_types) > 0) {	 
?>
		<p>
			<label><span style="color:red">*</span><?php echo $produt_type_label?></label><br />
			<select <?php if($vars['multiple']) echo $vars['multiple']; ?> id="<?php echo $vars['internalname']; ?>" name="<?php echo $vars['internalname']; ?><?php if($vars['multiple']) echo "[]"; ?>" <?php if (isset($vars['js'])) echo $vars['js']; ?> <?php if ((isset($vars['disabled'])) && ($vars['disabled'])) echo ' disabled="yes" '; ?> class="<?php echo $class; ?>">
			<?php
			    foreach($default_produt_types as $option) {
			        if ($option->value == $vars['value']  || in_array($option->value,$vars['value'])) {
			            echo "<option value=\"{$option->value}\" selected=\"selected\">". htmlentities($option->display_val, ENT_QUOTES, 'UTF-8') ."</option>";
			        } else {
			            echo "<option value=\"{$option->value}\">". htmlentities($option->display_val, ENT_QUOTES, 'UTF-8') ."</option>";
			        }
			    }
			?> 
			</select>
		</p>	
<?php
	}		
?>