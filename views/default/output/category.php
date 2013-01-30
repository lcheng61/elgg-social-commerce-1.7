<?php
	/**
	 * Elgg category - output view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	global $CONFIG;
	if ($vars['value']) {
		$category = get_entity($vars['value']);
		if ($vars['display'] <= 0)
			$vars['display'] = "";	 
		if($vars['display'] == 1){
			echo $category->title;
		}else{
?>
			<a  class="object_category_string" href="<?php echo $vars['url']; ?>pg/<?php echo $CONFIG->pluginname; ?>/<?php echo $vars['value']; ?>/product_cate">
				<?php echo $category->title; ?>
			</a>
<?php
		}
	}		
?>