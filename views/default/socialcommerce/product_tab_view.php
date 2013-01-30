<?PHP
	/**
	 * Elgg view - product tab
	 * 
	 * @package Elgg SocialCommerce
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Cubet Technologies
	 * @copyright Cubet Technologies 2009-2010
	 * @link http://elgghub.com/
 	**/
	 
	$base_view = $vars['base_view'];
	$filter = $vars['filter'];
	$baseurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$replace_url = preg_replace('/[\&\?]filter\=[a-z,A-Z]*/',"",$baseurl);
	$url = preg_replace('/[\&\?]offset\=[0-9]*/',"",$replace_url);
	if (substr_count($url,'?')) {
		$separator .= "&";
	} else {
		$separator .= "?";
	}
?>
<div class="bookraiser_profile">
	<div id="elgg_horizontal_tabbed_nav">
		<ul>
			<li <?php if($filter == "active") echo "class='selected'"; ?>><a href="<?php echo $url.$separator; ?>filter=active"><?php echo elgg_echo('active:products'); ?></a></li>
			<li <?php if($filter == "deleted") echo "class='selected'"; ?>><a href="<?php echo $url.$separator; ?>filter=deleted"><?php echo elgg_echo('deleted:products'); ?></a></li>
		</ul>
	</div>
	<?php echo $base_view; ?>
</div>