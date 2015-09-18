<?php
/* 
 * Validate user input
 */
function nattywp_validate_options($input) {
    $valid_input = array();
    
    $settings_output = nattywp_get_settings();  
    $options = $settings_output['nattywp_page_fields'];    
    $nattywp_option_name = $settings_output['nattywp_option_name'];
    $settings_group = $settings_output['page_option_name'];
    
    $input = $input[$settings_group];
    $valid_input[$settings_group] = $valid_input;
    $merged_options = get_option($nattywp_option_name);    
    
    foreach ($options as $option) {
      if(isset($option['filter'])) {
        switch ($option['filter']) {
           case 'multi':
              if(isset($input[$option['name']]))
                 $valid_input[$settings_group][$option['name']] = $input[$option['name']];
              else
                 $valid_input[$settings_group][$option['name']] = $option['default']; 
           break;
           
           case 'nohtml':
              $valid_input[$settings_group][$option['name']] = sanitize_text_field($input[$option['name']]);
              $valid_input[$settings_group][$option['name']] = strip_html_tags($valid_input[$settings_group][$option['name']]);
							$valid_input[$settings_group][$option['name']] = addslashes($valid_input[$settings_group][$option['name']]);     
           break;
           
           case 'url':
              $input[$option['name']] = trim($input[$option['name']]); // trim whitespace  
              $valid_input[$settings_group][$option['name']] = esc_url_raw($input[$option['name']]);  
           break;
           
           case 'num':
              $input[$option['name']] = trim($input[$option['name']]); // trim whitespace  
              $valid_input[$settings_group][$option['name']] = (is_numeric($input[$option['name']])) ? $input[$option['name']] : $option['default'];  
    
              // register error  
              if(is_numeric($input[$option['name']]) == FALSE) {  
                 add_settings_error($option['name'], 'nattywp_txt_numeric_error', __('Expecting a Numeric value! Please fix.','silesia'), 'error');  
              }
           break;
           
           default:
              $valid_input[$settings_group][$option['name']] = $input[$option['name']];
           break;
        }
      } else
       $valid_input[$settings_group][$option['name']] = $input[$option['name']];
    }
    
    if(!is_array($merged_options))
      $merged_options = array();
    return array_merge($merged_options, $valid_input);
}


function strip_html_tags($text)
{
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',"$0", "$0", "$0", "$0", "$0", "$0","$0", "$0",), $text);  
    return strip_tags($text);
}


/*
 * do AJAX
 */
function natty_ajax_callback() {
  global $natty_themename, $nattywp_option_name;
  
  $settings_group = '_options';
  $save_type = $_POST['type'];
  
  if($save_type == 'upload'){
		$clickedID = $_POST['data']; // Acts as the name, i.e nattywp_custom_logo		
		foreach ( $_FILES as $image ) {
      if ($image['size']) { // if a files was upload
        if (preg_match('/(jpg|jpeg|png|gif|x-icon)$/', $image['type'])) {
            $filename = $_FILES[$clickedID];		
            $filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
            
            $override = array('test_form' => false);
            $uploaded_file = wp_handle_upload($filename, $override);
                
            if(!empty($uploaded_file['error'])) {
                echo json_encode(array('error'=>'-1', 'message'=> __('Upload Error: ', 'silesia').$uploaded_file['error'])); 
            }	else {
                // no errors, do update                
                $options = get_option($nattywp_option_name);
                $options[$settings_group][$clickedID] = $uploaded_file['url'];                
                update_option($nattywp_option_name ,$options);
                echo json_encode(array('file'=>$uploaded_file['url']));
            } // Is the Response
         } else {
           // Not an image.
           echo json_encode(array('error'=>'-1', 'message'=> __('Wrong image type. Upload only .jpeg, .png or .gif images.', 'silesia')));
           die();
         }
       }
    }
	}
	if($save_type == 'image_reset'){      
			$clickedID = $_POST['data'];
			$options = get_option($nattywp_option_name);
      $options[$settings_group][$clickedID] = ''; // clear option                
      update_option($nattywp_option_name ,$options);
	}
  if ($save_type == 'color_options') {
      $data = $_POST['data'];
      parse_str($data,$output);  
      update_option($natty_themename.'_color_settings', $output);
  }
  die();
}