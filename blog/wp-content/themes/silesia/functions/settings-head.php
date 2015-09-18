<?php 
/* Admin Head: CSS, JS, etc. */

function nattywp_admin_styles() {
 	wp_register_style('natty-admin', get_template_directory_uri().'/functions/css/admin.css', array(), NULL);
 	wp_register_style('mooRainbow', get_template_directory_uri().'/functions/moorainbow/mooRainbow.css', array(), NULL);
 	wp_register_style('ui.multiselect', get_template_directory_uri().'/functions/css/ui.multiselect.css', array(), NULL);
 	// Enqueue
  wp_enqueue_style('mooRainbow');
  wp_enqueue_style('natty-admin');
  wp_enqueue_style('ui.multiselect');
}

function nattywp_admin_scripts() {
  wp_enqueue_script("jquery");
  
  wp_register_script('ajaxUpload', get_template_directory_uri().'/functions/js/ajaxupload.js', array(), NULL);
  wp_register_script('mootools', get_template_directory_uri().'/functions/js/mootools.js', array(), NULL);
	wp_register_script('mooRainbowJS', get_stylesheet_directory_uri() . '/functions/moorainbow/mooRainbow.js', array('mootools'), NULL);	
	wp_register_script('jquery-ui-custom', get_template_directory_uri().'/functions/js/jquery-ui.js', array('jquery'), NULL);
  wp_register_script('ui.multiselectJS', get_template_directory_uri().'/functions/js/ui.multiselect.js', array('jquery'), NULL);
	// Enqueue
	wp_enqueue_script("ajaxUpload");
		
	if($_REQUEST['page'] == 'nattywp_home') {
    wp_enqueue_script('jquery-ui-custom');
    wp_enqueue_script('ui.multiselectJS');
	}	
	if($_REQUEST['page'] == 'nattywp_color') {
    wp_enqueue_script("mootools");
    wp_enqueue_script("mooRainbowJS");
	}
}

function nattywp_admin_direct_scripts() {
  global $controls, $tcontrols, $path_theme, $path_rainbow_images, $preset_styles, $root_block;
  echo "<script type=\"text/javascript\">";
  if($_REQUEST['page'] == 'nattywp_color') {
    require_once (get_template_directory() . '/functions/js/color_control.php');
  } else {
    echo "jQuery(document).ready(function(){jQuery('.multiselect').multiselect();});"."\n";
  }
  require_once (get_template_directory() . '/functions/js/settings-ajax-control.php'); // AJAX
  echo "</script>"; 
}