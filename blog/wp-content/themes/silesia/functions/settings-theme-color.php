<?php 

/* ==================================  RENDER  COLOR  ============================== 
 * Prints out all settings sections added to a particular settings page
 */
function nattywp_do_settings_colors($page){
    global $wp_settings_sections, $wp_settings_fields, $natty_manualurl;

    if ( !isset($wp_settings_sections) || !isset($wp_settings_sections[$page]) )
      return;
    
    // Print main content
    echo '<div class="main-content"><h3 class="hndle">'.__('Color Settings','silesia').'</h3><div class="preview-box">';
      require_once (get_template_directory() . '/include/template-mini.php');
    echo '</div><div class="inside">';
    
    foreach ( (array) $wp_settings_sections[$page] as $i=>$section ) {
      call_user_func($section['callback'], $section);     
         
      if ( !isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section['id']]) )
         continue;
      
      // Print fields
      if ( $section['title'] )
        echo "<h3>{$section['title']}</h3>\n";
      echo "<div class=\"form-item\">";     
      nattywp_do_color_fields($page, $section['id']);
      echo '</div><br/>'; // end tab
    }
    echo '</div></div>';
}

function nattywp_do_color_fields($page, $section) {
    global $wp_settings_fields;
	
    if ( !isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section]) )
        return;

    foreach ((array) $wp_settings_fields[$page][$section] as $field ) {
      echo '<div class="form-item">';
      echo '<h4>' . $field['title'] . '</h4>';
      call_user_func($field['callback'], $field['args']);
      echo '<div class="clear"></div></div>';
    }
}



/* ============================ CALLBACK ==================================
 * Theme Options - Sections callback
 */
function nattywp_form_color_field_fn($args = array()) {
    extract($args);
    $settings_output = nattywp_get_settings();
    $nattywp_option_name = $settings_output['nattywp_option_name'];
    $settings_group = $settings_output['page_option_name'];
    $options = get_option($nattywp_option_name);
    
    if(isset($options[$settings_group]))
      $options = $options[$settings_group];
 
    // pass the default value
    if (!isset($options[$name]))
        $options[$name] = $default;
    
    // render form elements
    switch ($type) {
      case 'color':
      case 'color:hover':
      case 'background-color':
          $options[$name] = stripslashes($options[$name]);  
          $options[$name] = esc_attr($options[$name]);  
          echo "<input class='picker-input' type='text' size=\"7\" maxlenght=\"7\" id='$name' name='" . $nattywp_option_name . "[$settings_group][$name]' value='$options[$name]' onchange=\"get_option('$name')\" />";
          echo "<div class='picker' id='myRainbow_".$name."_input'><div class='overlay'></div></div>\n";
      break;
      
      case 'font-size':          
          echo "<select id='$name' class='select' name='" . $nattywp_option_name . "[$settings_group][$name]'>";
            foreach($sizes as $title=>$item) {
              $value  = esc_attr($item, 'silesia');
              $item   = esc_html($title, 'silesia');
              echo "<option value='$value'".selected($options[$name], $value).">$item</option>";  
            }  
          echo "</select>";      
      break;
      
      case 'background-image':
          echo "<input class='background-input' type='text' id='$name' name='" . $nattywp_option_name . "[$settings_group][$name]' value='$options[$name]' />";
      break;
      
      case 'select-custom':
          echo "<select id='$name' class='select' onchange=\"kDefaults()\" name='" . $nattywp_option_name . "[$settings_group][$name]'>";
            foreach($associated as $title=>$item) {
              $value  = esc_attr($item, 'silesia');
              $item   = esc_html($title, 'silesia');
              echo "<option value='$value'".selected($options[$name], $value).">$item</option>";  
            }  
          echo "</select>";
      break;
    }
}