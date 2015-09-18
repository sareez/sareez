<?php 
$natty_functions_path = get_template_directory() . '/functions/';

require_once ($natty_functions_path . 'admin-framework.php');
require_once ($natty_functions_path . 'admin-setup.php');
require_once ($natty_functions_path . 'admin-natty.php');
require_once ($natty_functions_path . 'custom-video.php');
require_once ($natty_functions_path . 'custom-title.php');
require_once ($natty_functions_path . 'shortcodes.php');
require_once ($natty_functions_path . '/tinymce/init.php');


if(is_admin()){
  require_once ($natty_functions_path . 'settings-general.php');
}
?>