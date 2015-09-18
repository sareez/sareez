<?php	
// if we can't find theme installed lets go ahead and install all the options that run template.  This should run only one more time for all our existing users, then they will just be getting the upgrade function if it exists.

if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	add_action('admin_head','natty_option_setup');
	header('Location: '.admin_url().'themes.php?page=nattywp_home');
}

function natty_option_setup() {
  global $controls, $tcontrols, $natty_themename, $nattywp_option_name, $preset_styles;
  
  if(!get_option($nattywp_option_name)) {  
      $framework_settings = array();
      $framework_settings['_options'] = array();
      foreach ($tcontrols as $option) {
          $framework_settings['_options'][$option['name']] = $option['default'];
      }
      
      foreach ($controls as $option) {
          $framework_settings['_colors'][$option['name']] = $option['default'];
      }
      
      add_option($nattywp_option_name, $framework_settings);
  }  
}

function natty_option_backup() {}
// Here we handle upgrading our users with new options and such.  If nhinstalled is in the DB but the version they are running is lower than our current version, trigger this event.
?>