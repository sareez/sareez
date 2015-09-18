<?php 
/**
* @version		v.1.0
* @copyright	Copyright (C) 2008 NattyWP. All rights reserved.
* @author		Dave Miller
*/
// Printerest Widget

function printerestWidget($args)
{
	extract( $args, EXTR_SKIP );
	$settings = get_option("widget_printerestwidget");
	$title = $settings['title'];
	$id = $settings['id'];
	$number = $settings['number'];	

	echo $before_widget;
?>
	
				<?php echo $before_title . $title . $after_title; ?>
				
				<div class="printerest-pic">	
					<script type="text/javascript" src="http://www.pinterest.com/senoritasareez=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>        
				</div>
			<div style="clear:both;"></div>
<?php
	echo $after_widget;
}

function printerestWidgetAdmin() {

	$settings = get_option("widget_printerestwidget");

	// check if anything's been sent
	if (isset($_POST['update_printerst'])) {
		$settings['title'] = strip_tags(stripslashes($_POST['printerst_title']));
		$settings['id'] = strip_tags(stripslashes($_POST['printerst_id']));
		$settings['number'] = strip_tags(stripslashes($_POST['printerst_number']));

		update_option("widget_printerstwidget", $settings);
	}

	echo '<p>
			<label for="printerest_title">'.__('Title:', 'silesia').'
			<input id="printerest_title" name="printerest_title" type="text" class="widefat" value="'.$settings['title'].'" /></label></p>';
			
	echo '<p>
			<label for="printerest_id">'.__('Printerest ID', 'silesia').' (<a href="http://www.idgettr.com">idGettr</a>):
			<input id="printerest_id" name="printerest_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';
	echo '<p>
			<label for="printerest_number">'.__('Number of photos:', 'silesia').'
			<input id="printerest_number" name="printerest_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_printerest" name="update_printerest" value="1" />';

}

function printerestWidget_register(){
	wp_register_sidebar_widget('printerest-1', __('NattyWP Printerest', 'silesia'), 'printerestWidget');
	wp_register_widget_control('printerest-1', __('NattyWP Printerest', 'silesia'), 'printerestWidgetAdmin', 300, 200);
}

add_action('widgets_init', 'printerestWidget_register');

?>