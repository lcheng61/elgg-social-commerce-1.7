<?php
	/**
	 * Elgg search - over write gallery view
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	$entities = $vars['entities'];
	if (is_array($entities) && sizeof($entities) > 0) {
		
?>

	<table class="search_gallery">
		<tr>
<?php
		$col = 0;
		foreach($entities as $entity) {
			if ($col%5 == 0 && $col != 0) {
				echo "</tr><tr>";
			}
			echo "<td class=\"product_gallery_item\">";
			echo elgg_view_entity($entity);
			echo "</td>";
			$col++;			
		}
		if ($col > 0) echo "</tr>";
		
?>
		</tr>
	</table>


<?php
		
	}
	
?>