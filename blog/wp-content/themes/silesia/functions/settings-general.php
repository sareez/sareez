<?php 
// Settings Hooks
add_action('admin_menu', 'nattywp_add_admin_menu');
add_action('admin_init', 'nattywp_register_settings');
add_action('wp_ajax_natty_ajax_post_action', 'natty_ajax_callback'); // ajax process

require_once ('settings-head.php');
require_once('settings-validate.php');
require_once('settings-theme.php');
require_once('settings-theme-color.php');

/* Admin menu pages */
function nattywp_add_admin_menu() {
    add_action('admin_print_styles', 'nattywp_admin_styles'); // styles
  if(isset($_REQUEST['page']) && ($_REQUEST['page'] == 'nattywp_home' || $_REQUEST['page'] == 'nattywp_color')) {    
    add_action('admin_enqueue_scripts', 'nattywp_admin_scripts'); // scripts
    add_action('admin_head', 'nattywp_admin_direct_scripts'); // direct scripts
  }
  
  add_theme_page(__('Theme Options', 'silesia'), __('Theme Options', 'silesia'), 'edit_theme_options', 'nattywp_home', 'nattywp_settings_page_fn');
  add_theme_page(__('Color Options', 'silesia'), __('Color Options', 'silesia'), 'edit_theme_options', 'nattywp_color', 'nattywp_color_page_fn');
  add_theme_page(__('More themes', 'silesia'), __('More themes', 'silesia'), 'edit_theme_options', 'more-nattywp', 'nattywp_more_themes_page');
}


// Theme settings
function nattywp_get_settings() {
    global $natty_themename, $nattywp_option_name, $natty_include_path, $pagenow;    
    
    if($pagenow == 'options.php') {
        $parts  = explode('page=', $_POST['_wp_http_referer']);  
        $current_page   = $parts[1];
    } elseif(isset($_GET['page'])) {
        $current_page = trim($_GET['page']);
    } else {
        $current_page = null;
    }
    
    if($current_page == 'nattywp_home') {
      // Settings
      require ($natty_include_path . 'settings-theme.php');
      
      $settings_output = array(
        'nattywp_option_name' => $nattywp_option_name,
        'page_option_name' => '_options', // admin-setup also
        'nattywp_page_sections' => $sections_controls, // the setting section
        'nattywp_page_fields' => $tcontrols,
        'nattywp_form_field' => 'nattywp_form_field_fn',
      );
      return $settings_output;
    } 
    
    if($current_page == 'nattywp_color') {
      // Color
      require ($natty_include_path . 'settings-color.php');
    
      $settings_output = array(
        'nattywp_option_name' => $nattywp_option_name,
        'page_option_name' => '_colors',
        'nattywp_page_sections' => $sections_controls, // the setting section
        'nattywp_page_fields' => $controls,
        'nattywp_form_field' => 'nattywp_form_color_field_fn',
      );
      return $settings_output;
    }
}



function nattywp_register_settings(){
    $settings_output = nattywp_get_settings();
    $nattywp_option_name = $settings_output['nattywp_option_name'];    
    
    // validate
    register_setting($nattywp_option_name, $nattywp_option_name, 'nattywp_validate_options');
    
    // sections settings
    if(!empty($settings_output['nattywp_page_sections'])){
       foreach ( $settings_output['nattywp_page_sections'] as $id => $title ) {
          add_settings_section($title[0], $title['title'], 'nattywp_section_fn', __FILE__);
       }
    }    
    
    //fields
    if(!empty($settings_output['nattywp_page_fields'])){  
       foreach ($settings_output['nattywp_page_fields'] as $option)
          add_settings_field($option['name'], $option['title'], $settings_output['nattywp_form_field'], __FILE__, $option['section'][0], $option); 
    }
}




/* ============================ CALLBACK ==================================
 * Theme Options - Sections callback
 */
function nattywp_section_fn($desc) {}



/*
 * Theme Options - Page Render callback
 */
function nattywp_color_page_fn(){ 
  nattywp_settings_page_fn('color'); 
}


/*
 * Theme Options - Page Render callback
 */
function nattywp_settings_page_fn($page) {
  global $nattywp_option_name, $natty_themename, $natty_manualurl, $natty_current;
?>  
  <div class="wrap">
  <div class="natty-options">
  <form action="options.php" method="post" enctype="multipart/form-data" id="natty-options_form">    
    <div class="header">
      <div class="main-top">
        <div class="general-pad">
         <div class="left">
            <h1><?php echo $natty_themename; ?> &rarr; <span class="blu"><?php _e('Theme Options', 'silesia'); ?></span></h1>
            <small><?php _e('Theme Version:', 'silesia'); ?> <?php echo $natty_current; ?></small>
         </div>
         <div class="right">
          <span class="copy"><?php _e('Theme by', 'silesia'); ?> <a href="http://www.nattywp.com">NattyWP</a></span>
          <div class="social">
              <ul>
                <li class="tit"><small><?php _e('Follow Us:', 'silesia'); ?></small></li>
                <li class="rss"><a href="http://www.nattywp.com/feed/rss.xml" class="png_crop">rss</a></li>
                <li class="twitter"><a href="http://twitter.com/nattywp" class="png_crop">twitter</a></li>
              </ul><div class="clear"></div>
          </div>            
         </div>   
         <div class="clear"></div>   
         </div>
      </div>
      <div class="supportline">
       <div class="general-pad-two">
        <div class="left">
          <a class="ico-docs" href="<?php echo $natty_manualurl; ?>"><?php _e('Theme Documentation', 'silesia'); ?></a>
          <a class="ico-support" href="http://support.nattywp.com"><?php _e('Submit a Ticket <small>(register first)</small>', 'silesia'); ?></a>
        </div>
        <div class="right">
             	<img style="display:none" src="<?php echo get_template_directory_uri(); ?>/functions/images/loading.gif" class="ajax-loading-img ajax-loading-img-top" alt="Working..." /><input type="submit" value="<?php _e('Update Options', 'silesia') ?> &raquo;" class="button button-primary submit-button natty-options-submit" />
        </div>
        <div class="clear"></div>
        </div>
      </div>
    </div> <!-- end header -->
    
<div id="main"<?php if($page == 'color') {echo ' class="color-page"';} else { echo ' class="settings-page"';} ?>> 
  <div id="natty-popup-save" class="save-popup"><div class="popup-bg">Options Updated</div></div>
  <div id="natty-popup-backup" class="save-popup"><div class="popup-bg">Options Backuped</div></div>
  <div id="natty-popup-restore" class="save-popup"><div class="popup-bg">Options Restored</div></div>
  <?php
    settings_fields($nattywp_option_name);
    if($page == 'color') {
      nattywp_do_settings_colors(__FILE__);
    } else {
      nattywp_do_settings_sections(__FILE__);
    }
	?>
	<div class="clear"></div>
</div> <!-- end main -->

  <div class="footer"><div class="general-pad-two"><div class="right"><input type="submit" class="natty-options-submit button-primary" name="Submit" value="<?php _e('Update Options', 'silesia') ?> &raquo;" /></div><div class="clear"></div></div></div>    
</form>
<div style="clear:both;"></div>  
</div> <!-- natty-options -->  
</div><!--wrap-->
<?php }