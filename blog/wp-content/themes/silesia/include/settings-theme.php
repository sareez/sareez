<?php
	// control's types
	// ---------------
	$control_types = array(
		0 => 'textarea',
		1 => 'input',		
		2 => 'select-bool',
		3 => 'select',
		4 => 'multi-select',
		5 => 'upload',
		6 => 'sort-item'
	);
	
	// sections controls
	// -----------------
	//$sections_controls = array();  
  //$sections_controls['txt_section']    = __('Text Form Fields', 'wptuts_textdomain');  
    
	$sections_controls = array(
		array('general', 'title' => __('General Options', 'silesia')),
		array('front_page', 'title' => __('Front Page Settings', 'silesia')),
		array('social_profiles', 'title' => __('Social Profiles & Tracking', 'silesia')),
	);
	
	// Numbers
	$num_data = array ('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19');
	
	
	// controls
	// --------
	$tcontrols = array();
	
	$tcontrols[] = array (
			'name' => 'nattywp_custom_logo',					// id for control
			'title' => __('Custom Logo', 'silesia'),				// Title
			'section' => $sections_controls[0],			// Section -> see $sections_controls array
			'type' => $control_types[5],				// Type -> see $control_types array	
			'desc' => __('Default logo text can be edited under Wordpress <a href="options-general.php">General Settings -> Site Title</a> or replaced by your custom logo image.', 'silesia'),
			'default' => ''		
		);
	$tcontrols[] = array (
			'name' => 't_hide_tagline',
			'title' => __('Hide Tagline under Logo?', 'silesia'),
			'section' => $sections_controls[0],
			'type' => $control_types[2],
			'mode' => 'bool',
			'desc' => __('Control visibility of tagline. You can configure tagline text under Wordpress Settings -> <a href="options-general.php">General tab</a>.', 'silesia'),
			'default' => 'no'
		);	
	$tcontrols[] = array (
			'name' => 't_home_name',
			'title' => __('Home Link Text', 'silesia'),
			'section' => $sections_controls[0],
			'type' => $control_types[1],
			'desc' => __('Enter a Home link text for breadcrumbs navigation.', 'silesia'),
			'default' => 'Home'
		);
	$tcontrols[] = array (
			'name' => 'nattywp_custom_favicon',
			'title' => __('Custom Favicon.ico upload', 'silesia'),
			'section' => $sections_controls[0],
			'type' => $control_types[5],
			'btn_name' => __('Upload .ICO file', 'silesia'),
			'desc' => __('Use <a href="http://www.faviconer.com" target="_blank">Faviconer.com</a> to create unique favicon.ico image.', 'silesia'),
			'default' => ''
	);		
	$tcontrols[] = array (
			'name' => 't_meta_desc',					// id for control
			'title' => __('Meta Description', 'silesia'),				// Title
			'section' => $sections_controls[0],			// Section -> see $sections_controls array
			'type' => $control_types[0],				// Type -> see $control_types array	
			'desc' => __('Enter a blurb about your site here, and it will show up on the &lt;meta name=&quot;description&quot;&gt; tag. Useful for SEO. <br/><br/>Just plain text, all HTML tags will be removed.', 'silesia'),
			'filter' => 'nohtml',
			'default' => ''		
		);	

	$tcontrols[] = array (
			'name' => 't_show_post',
			'title' => __('Show Fullposts?', 'silesia'),
			'section' => $sections_controls[0],
			'type' => $control_types[2],
			'mode' => 'bool',
			'desc' => __('Show fullposts instead of post summary?', 'silesia'),
			'default' => 'yes'
		);
	$tcontrols[] = array (
			'name' => 't_head_nav',
			'title' => __('Header Navigation', 'silesia'),
			'section' => $sections_controls[0],
			'type' => $control_types[3],
			'associated' => array(
          __('Display Breadcrumbs', 'silesia') => 'crumbs',
          __('Display Navigation menu', 'silesia') => 'nav',
       ),
			'desc' => __('Choose Header navigation style', 'silesia'),
			'default' => 'crumbs'
		);
		
	$tcontrols[] = array (
			'name' => 't_show_slideshow',
			'title' => __('Header Area Settings', 'silesia'),
			'section' => $sections_controls[1],
			'type' => $control_types[3],			
			'associated' => array(
          __('Turn Off Header section', 'silesia') => 'hide',
          __('Display Header Image', 'silesia') => 'yes',
          __('Display Page Slideshow', 'silesia') => 'pag'
       ),
			'desc' => __('This option helps you to control your header area. Select: <br />
			<strong>Turn Off Header section</strong> - to completely remove header area from display.<br />
			<strong>Header Image</strong> - to display <a href="?page=custom-header">Uploaded Header</a>.<br />
			<strong>Page Slideshow</strong> - to create a Page-based slider with Featured images.', 'silesia'),
			'default' => 'hide'
		);			 
	$tcontrols[] = array (
			'name' => 't_scroll_pages',
			'name_get' => 't_scroll_pages[]',
			'title' => __('Homepage Scrolling pages', 'silesia'),
			'section' => $sections_controls[1],
			'type' => $control_types[6],	
			'desc' => __('<strong>Note:</strong> Please make sure that you selected <i>"Display Page Slideshow"</i> option under <strong>Header Area Settings</strong>.<br/> To add pages click on the "Plus" icon at the right side. To order pages click and move item at the left side.', 'silesia'),
			'filter' => 'multi',
			'default' => 'no'
		);		
	$tcontrols[] = array (
			'name' => 't_slide_effect',
			'title' => __('Slideshow effect', 'silesia'),
			'section' => $sections_controls[1],
			'type' => $control_types[3],			
			'associated' => array(
			'blindX' => 'blindX',
			'blindY' => 'blindY',
			'blindZ' => 'blindZ',
			'cover' => 'cover',
			'curtainX' => 'curtainX',
			'curtainY' => 'curtainY',
      'fade' => 'fade',
      'fadeZoom' => 'fadeZoom',
      'growX' => 'growX',
      'growY' => 'growY',
      'none' => 'none',
      'scrollUp' => 'scrollUp',
      'scrollDown' => 'scrollDown',
			'scrollLeft' => 'scrollLeft',
      'scrollRight' => 'scrollRight',
      'scrollHorz' => 'scrollHorz',
      'scrollVert' => 'scrollVert',
      'shuffle' => 'shuffle',
      'slideX' => 'slideX',
      'slideY' => 'slideY',
      'toss' => 'toss',
      'turnUp' => 'turnUp',
      'turnDown' => 'turnDown',
      'turnLeft' => 'turnLeft',
      'turnRight' => 'turnRight',
      'uncover' => 'uncover',
      'wipe' => 'wipe',
      'zoom' => 'zoom'
	),
			'desc' => __('Select transition effect for homepage slideshow.', 'silesia'),
			'default' => 'turnDown'
		);		
$tcontrols[] = array (
			'name' => 't_timeout',
			'title' => __('Timeout', 'silesia'),
			'section' => $sections_controls[1],
			'type' => $control_types[1],
			'desc' => __('Milliseconds between slide transitions (0 to disable auto advance)', 'silesia'),
			'field_class' => 'array',
			'filter' => 'num',
			'default' => '6000'		
		);	
  $tcontrols[] = array (
			'name' => 't_slide_speed',
			'title' => __('Slide speed', 'silesia'),
			'section' => $sections_controls[1],
			'type' => $control_types[1],
			'field_class' => 'array',
			'desc' => __('Speed of the transition (in milliseconds)', 'silesia'),
			'filter' => 'num',
			'default' => '1000'		
		);
		
	$tcontrols[] = array (
			'name' => 't_hide_social',
			'title' => __('Hide Social Profile Links (Header area) ?', 'silesia'),
			'section' => $sections_controls[2],
			'type' => $control_types[2],
			'mode' => 'bool',
			'desc' => __('Control visibility of the Social Buttons.', 'silesia'),
			'default' => 'yes'
		);	
	$tcontrols[] = array (
			'name' => 't_twitterurl',				// id for control
			'title' => __('Twitter URL', 'silesia'),				// Title
			'section' => $sections_controls[2],			// Section -> see $sections_controls array
			'type' => $control_types[1],				// Type -> see $control_types array	
			'desc' => __('Link to your twitter page. Start with http://', 'silesia'),
			'filter' => 'url',
			'default' => 'http://twitter.com/nattywp'		
		);
	$tcontrols[] = array (
			'name' => 't_facebookurl',				// id for control
			'title' => __('Facebook URL', 'silesia'),				// Title
			'section' => $sections_controls[2],			// Section -> see $sections_controls array
			'type' => $control_types[1],				// Type -> see $control_types array	
			'desc' => __('Link to your facebook page. Start with http://', 'silesia'),
			'filter' => 'url',
			'default' => 'http://www.facebook.com/faviconer'		
		);		
	$tcontrols[] = array (
			'name' => 't_feedburnerurl',				// id for control
			'title' => __('Feedburner URL', 'silesia'),				// Title
			'section' => $sections_controls[2],			// Section -> see $sections_controls array
			'type' => $control_types[1],				// Type -> see $control_types array	
			'filter' => 'url',
			'desc' => __('<a href="http://feedburner.google.com" target="_blank">Feedburner</a> URL. This will replace RSS feed link. Start with http://', 'silesia'),
			'default' => ''		
		);
	$tcontrols[] = array (
			'name' => 't_tracking',					// id for control
			'title' => __('Tracking Code', 'silesia'),					// Title
			'section' => $sections_controls[2],			// Section -> see $sections_controls array
			'type' => $control_types[0],				// Type -> see $control_types array	
			'desc' => __('Put your tracking code here and manage your website statistics. <br /><br /><strong>Note:</strong> JS code including <i>&lt;script&gt;...&lt;/script&gt; tags</i>', 'silesia'),
			'default' => ''		
		);	
?>