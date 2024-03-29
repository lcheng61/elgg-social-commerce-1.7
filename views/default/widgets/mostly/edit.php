<?php
/**
 * Elgg widget - mostly - edit
 * 
 * @package Elgg SocialCommerce
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Cubet Technologies
 * @copyright Cubet Technologies 2009-2010
 * @link http://elgghub.com/
 **/
?>
<p>
	<?php echo elgg_echo("stores:num_products"); ?>:
	<select name="params[num_display]">
	    <option value="1" <?php if($vars['entity']->num_display == 1) echo "SELECTED"; ?>>1</option>
	    <option value="2" <?php if($vars['entity']->num_display == 2) echo "SELECTED"; ?>>2</option>
	    <option value="3" <?php if($vars['entity']->num_display == 3) echo "SELECTED"; ?>>3</option>
	    <option value="4" <?php if($vars['entity']->num_display == 4) echo "SELECTED"; ?>>4</option>
	    <option value="5" <?php if($vars['entity']->num_display == 5) echo "SELECTED"; ?>>5</option>
	    <option value="6" <?php if($vars['entity']->num_display == 6) echo "SELECTED"; ?>>6</option>
	    <option value="7" <?php if($vars['entity']->num_display == 7) echo "SELECTED"; ?>>7</option>
	    <option value="8" <?php if($vars['entity']->num_display == 8) echo "SELECTED"; ?>>8</option>
	    <option value="9" <?php if($vars['entity']->num_display == 9) echo "SELECTED"; ?>>9</option>
	    <option value="10" <?php if($vars['entity']->num_display == 10) echo "SELECTED"; ?>>10</option>
	    <option value="15" <?php if($vars['entity']->num_display == 15) echo "SELECTED"; ?>>15</option>
	    <option value="20" <?php if($vars['entity']->num_display == 20) echo "SELECTED"; ?>>20</option>
	</select>
</p>

<p>
    <?php echo elgg_echo("stores:display");?>:
    <select name="params[product_display]">
        <option value="1" <?php if($vars['entity']->product_display == 1) echo "SELECTED"; ?>><?php echo elgg_echo("my:stores"); ?></option>
	    <option value="2" <?php if($vars['entity']->product_display == 2) echo "SELECTED"; ?>><?php echo elgg_echo("friends:stores"); ?></option>
	    <option value="3" <?php if($vars['entity']->product_display == 3) echo "SELECTED"; ?>><?php echo elgg_echo("all:stores"); ?></option>
    </select>
</p>

<p>
    <?php echo elgg_echo("stores:gallery_list"); ?>:
    <select name="params[gallery_list]">
        <option value="1" <?php if($vars['entity']->gallery_list == 1) echo "SELECTED"; ?>><?php echo elgg_echo("stores:list"); ?></option>
	    <option value="2" <?php if($vars['entity']->gallery_list == 2) echo "SELECTED"; ?>><?php echo elgg_echo("stores:gallery"); ?></option>
    </select>
</p>