<?php 
/* ==================================  RENDER  SETTINGS  ============================== 
 * Prints out all settings sections added to a particular settings page
 */
function nattywp_do_settings_sections($page){
    global $wp_settings_sections, $wp_settings_fields, $natty_manualurl;

    if ( !isset($wp_settings_sections) || !isset($wp_settings_sections[$page]) )
      return;
      
    // Print left menu
    echo '<div class="frame-nav"><ul><li><a href="#nat-wellcome">'.__('Welcome', 'silesia').'</a></li>';
    foreach ( (array) $wp_settings_sections[$page] as $i=>$section ) {
      if ( $section['title'] )
        echo "<li><a href=\"#{$i}\">{$section['title']}</a></li>\n";      
    }
    echo '</ul></div>';
    
    // Print main content
    echo '<div class="main-content">';
    require_once (get_template_directory() . '/include/settings-intro.php');
    foreach ( (array) $wp_settings_sections[$page] as $i=>$section ) {
      call_user_func($section['callback'], $section);     
         
      if ( !isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section['id']]) )
         continue;
      
      // Print fields  
      echo "<div id=\"{$i}\" class=\"tab\">";
      nattywp_do_settings_fields($page, $section['id']);
      echo '</div>'; // end tab
    }
    echo '</div>';
}

function nattywp_do_settings_fields($page, $section) {
    global $wp_settings_fields;
	
    if ( !isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section]) )
        return;

    foreach ((array) $wp_settings_fields[$page][$section] as $field ) {       
      
      $field_class = ''; // additional field class (only if defined)
      if(isset($field['args']['field_class']))
        $field_class = ' '.$field['args']['field_class'];

      echo '<div class="form-item'.$field_class.'">';
      echo '<h4>' . $field['title'] . '</h4>';
      call_user_func($field['callback'], $field['args']);
      echo '<div class="clear"></div></div>';
    }
}



/* ============================ CALLBACK ==================================
 * Theme Options - Sections callback
 */


/*
 * Theme Options - Fields callback
 */
function nattywp_form_field_fn($args = array()) {
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
      case 'input':
          $options[$name] = stripslashes($options[$name]);  
          $options[$name] = esc_attr($options[$name]);  
          echo "<input class='regular-text' type='text' id='$name' name='" . $nattywp_option_name . "[$settings_group][$name]' value='$options[$name]' />";  
          echo ($desc != '') ? "<div class='description'>$desc</div>" : "";  
      break;
      
      case 'textarea':
          $options[$name] = stripslashes($options[$name]);  
          $options[$name] = esc_html($options[$name]);  
          echo "<textarea class='textarea' type='text' id='$name' name='" . $nattywp_option_name . "[$settings_group][$name]' rows='5' cols='30'>$options[$name]</textarea>";  
          echo ($desc != '') ? "<div class='description'>$desc</div>" : "";  
      break;
      
      case 'select':
          echo "<select id='$name' class='select' name='" . $nattywp_option_name . "[$settings_group][$name]'>";
            foreach($associated as $title=>$item) {
              $value  = esc_attr($item, 'silesia');
              $item   = esc_html($title, 'silesia');
              echo "<option value='$value'".selected($options[$name], $value).">$item</option>";  
            }  
          echo "</select>";  
          echo ($desc != '') ? "<div class='description'>$desc</div>" : "";  
      break;
      
      case 'select-bool':
          $boolean_var = array(
            __('Yes', 'silesia') => 'yes',
            __('No', 'silesia') => 'no',
          );          
          echo "<select id='$name' class='select' name='" . $nattywp_option_name . "[$settings_group][$name]'>";
            foreach($boolean_var as $title=>$item) {
              $value  = esc_attr($item, 'silesia');
              $item   = esc_html($title, 'silesia');
              echo "<option value='$value'".selected($options[$name], $value).">$item</option>";  
            }  
          echo "</select>";  
          echo ($desc != '') ? "<div class='description'>$desc</div>" : "";
      break;
      
      case 'upload':
         if(!isset($btn_name))
            $btn_name = __('Upload Image', 'silesia');
            
         echo "<div class='form-uploader'><input class='upl-inp' name='". $nattywp_option_name ."[$settings_group][$name]' id='".$name."_upload' type='text' value='$options[$name]' />";
         echo '<div class="upload_button_div"><span class="button image_upload_button" id="'.$name.'">'.$btn_name.'</span>';
         
         if(!empty($options[$name])) {$hide = '';} else { $hide = 'hide';}
         echo '<span class="button image_reset_button '. $hide.'" id="reset_'. $name .'" title="' . $name . '">'.__('Remove', 'silesia').'</span></div>'. "\n";         
         
         if(!empty($options[$name])){
              echo '<div class="clear"></div>' . "\n";
              echo '<img class="custom-logo-image" id="image_'.$name.'" src="'.$options[$name].'" alt="" />';
         }
         echo '<div class="clear"></div> </div>' . "\n";       
         echo ($desc != '') ? "<div class='description'>$desc</div>" : "";  
      break;
      
      case 'multi-select':
          echo "<select multiple=\"true\" size=\"7\" style=\"height:150px;\" id='$name' class='multi-select' name='" . $nattywp_option_name . "[$settings_group][$name][]'>";
            foreach($associated as $title=>$item) {
              $value  = esc_attr($item, 'silesia');
              $item   = esc_html($title, 'silesia');
              echo "<option value='$value'".selected($options[$name], $value).">$item</option>";  
            }  
          echo "</select>";  
          echo ($desc != '') ? "<div class='description'>$desc</div>" : "";  
      break;
      
      case 'sort-item':
         $pn_pages = get_pages('');
         foreach ( $pn_pages as $pag ) {
            $pn_pag[] = array( $pag->ID, $pag->post_title );
         }
         
         echo "<select id='$name' class=\"multiselect\" multiple=\"multiple\" name='".$nattywp_option_name."[$settings_group][$name][]'>";         
         
         foreach ($pn_pag as $key=>$arr) {
          if (is_array($options[$name]))
              echo "<option value=\"" . $arr[0] . "\"".selected(in_array($arr[ 0 ], $options[$name]), true).">" . $arr[ 1 ] . "</option>\n";
          else
              echo "<option value=\"" . $arr[0] . "\"".selected($arr[0], 'no').">" . $arr[ 1 ] . "</option>\n";
         }
         echo "</select><div id=\"switcher\"></div>";  
         echo ($desc != '') ? "<div class='description inline'>$desc</div>" : "";
      break;
    }
}