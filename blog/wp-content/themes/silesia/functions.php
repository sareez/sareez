<?php
$natty_themename = 'silesia';
$natty_current = '1.0.6';

$natty_manualurl = 'http://support.nattywp.com/index.php?act=kb';

$nattywp_option_name = $natty_themename.'_nattywp';
$natty_functions_path = get_template_directory() . '/functions/';
$natty_include_path = get_template_directory() . '/include/';
$natty_license_path = get_template_directory() . '/license/';

require_once ($natty_include_path . 'settings-color.php');
require_once ($natty_include_path . 'settings-theme.php');
require_once ($natty_include_path . 'settings-comments.php');

require_once ($natty_functions_path . 'core-init.php');

require_once ($natty_include_path . 'hooks.php');
require_once ($natty_include_path . 'sidebar-init.php');
require_once ($natty_include_path . 'widgets/flickr.php');
require_once ($natty_include_path . 'widgets/feedburner.php');
require_once ($natty_include_path . 'widgets/twitter.php');
require_once ($natty_include_path . 'widgets/printerest.php');
?>