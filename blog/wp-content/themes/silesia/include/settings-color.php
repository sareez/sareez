<?php
	// paths
	// -----
	$path_theme = get_template_directory_uri();
	$path_images = $path_theme.'/images/';
	$path_rainbow_images = $path_theme.'/functions/moorainbow/images/';
	
	// control's types
	// ---------------
	$control_types = array(
		0 => 'background-color',
		1 => 'background-image',
		2 => 'color',
		3 => 'color:hover',
		4 => 'font-size',
		5 => 'select-custom'
	);
	
	// sections controls
	// -----------------
	$sections_controls = array(
    array('preset', 'title' => __('Preset Color scheme.', 'silesia')),
    array('header', 'title' => __('Header.', 'silesia')),
		array('slide_sidebar', 'title' => __('Slide Sidebar.', 'silesia')),
		array('post_text', 'title' => __('Post Text and Link styles.', 'silesia')),
		array('sidebar', 'title' => __('Sidebar.', 'silesia')),
	);
	
	$root_block = 'background-image-div';
	
	// controls
	// -------- 
	$controls = array(
	$controls[] = array(
			'name' => 'paramspresetStyle',
			'title' => __('Preset Color scheme','silesia'),
			'section' => $sections_controls[0], // Manage your template color scheme
			'type' => $control_types[5],
			'associated' => array(
          __('Silesia default style', 'silesia') => 'style0',
          __('Custom style', 'silesia') => 'custom'
       ),
			'default' => 'style0'
		),
		
	$controls[] = array(
			'name' => 't_head_background_color',
			'title' => __('Header - Background color', 'silesia'),
			'section' => $sections_controls[1], // Manage your template color scheme
			'type' => $control_types[0],
			'selector' => '#header',
			'selector-mini' => '#background-color-div',
			'default' => 'F7F7F7'
		),
	$controls[] = array(
			'name' => 't_logo_text_color',
			'title' => __('Header - Logo Text color', 'silesia'),
			'section' => $sections_controls[1], // Top navigation.
			'type' => $control_types[2],
			'selector' => '#main-nav, #main-nav a#control, #link-sidebar h2',
			'selector-mini' => '#logo-text',
			'default' => '30353A'
		),		
	$controls[] = array(
			'name' => 't_head_text_color',
			'title' => __('Header - Text color', 'silesia'),
			'section' => $sections_controls[1], // Top navigation.
			'type' => $control_types[2],
			'selector' => '#header .tagline',
			'selector-mini' => '#logo-text',
			'default' => 'BBBBBB'
		),
	
	$controls[] = array(
			'name' => 't_slide_background_color',
			'title' => __('Slide - Background color', 'silesia'),
			'section' => $sections_controls[2], // Manage your template color scheme
			'type' => $control_types[0],
			'selector' => '#main-nav',
			'selector-mini' => '#slide-sidebar',
			'default' => '527F8D'
		),
	$controls[] = array(
			'name' => 't_slide_text_color',
			'title' => __('Slide - Text color', 'silesia'),
			'section' => $sections_controls[2], // Top navigation.
			'type' => $control_types[2],
			'selector' => '#main-nav, #main-nav a#control, #link-sidebar h2',
			'selector-mini' => '#slide-sidebar',
			'default' => 'ffffff'
		),
		$controls[] = array(
			'name' => 't_slide_link_color',
			'title' => __('Slide - Link color', 'silesia'),
			'section' => $sections_controls[2], // Top navigation.
			'type' => $control_types[2],
			'selector' => '#link-sidebar a, #main-nav a#control:hover',
			'selector-mini' => '#slide-sidebar a',
			'default' => 'D8F1FA'
		),
	$controls[] = array(
			'name' => 't_slide_linkactive_color',
			'title' => __('Slide - Link hover', 'silesia'),
			'section' => $sections_controls[2], // Top navigation.
			'type' => $control_types[3],
			'selector' => '#link-sidebar ul li.widget a:hover',
			'selector-mini' => '#slide-sidebar a',
			'color-control' => 't_slide_link_color',
			'default' => 'ffffff'
	),
	
  $controls[] = array(
			'name' => 't_title_color',
			'title' => __('H1 Title text color', 'silesia'),
			'section' => $sections_controls[3], // Scrolling area.
			'type' => $control_types[2],
			'selector' => '.hentry h2, .hentry h2 a, .singlepage .post h2, .singlepage .page.comments h2',
			'selector-mini' => '#test-text h1',
			'default' => '434343'
		),
	$controls[] = array(
			'name' => 't_text_color',
			'title' => __('Text color', 'silesia'),
			'section' => $sections_controls[3], // Top navigation.
			'type' => $control_types[2],
			'selector' => '.p-cont .entry, .singlepage .entry',
			'selector-mini' => '#test-text',
			'default' => '4D4D4F'
		),	
	$controls[] = array(
			'name' => 't_link_color',
			'title' => __('Link color', 'silesia'),
			'section' => $sections_controls[3], // Top navigation.
			'type' => $control_types[2],
			'selector' => '.post a, .page.comments a',
			'selector-mini' => '#test-text a',
			'default' => '0E73B8'
		),
	$controls[] = array(
			'name' => 't_linkactive_color',
			'title' => __('Link hover (highlight) color', 'silesia'),
			'section' => $sections_controls[3], // Top navigation.
			'type' => $control_types[3],
			'selector' => '.post a:hover, .page.comments a:hover, .hentry h2 a:hover',
			'selector-mini' => '#test-text a',
			'color-control' => 't_link_color',
			'default' => 'ff0505'
		),
		
	
	$controls[] = array(
			'name' => 't_side_title_color',
			'title' => __('Sidebar - H1 Title color', 'silesia'),
			'section' => $sections_controls[4], // Scrolling area.
			'type' => $control_types[2],
			'selector' => '#sidebar h2',
			'selector-mini' => '#sidebar h1',
			'default' => '4D4D4F'
		),
	$controls[] = array(
			'name' => 't_side_text_color',
			'title' => __('Sidebar - Text color', 'silesia'),
			'section' => $sections_controls[4], // Top navigation.
			'type' => $control_types[2],
			'selector' => '#sidebar',
			'selector-mini' => '#sidebar',
			'default' => '555555'
		),	
	$controls[] = array(
			'name' => 't_side_link_color',
			'title' => __('Sidebar - Link color', 'silesia'),
			'section' => $sections_controls[4], // Top navigation.
			'type' => $control_types[2],
			'selector' => '#sidebar a',
			'selector-mini' => '#sidebar a',
			'default' => '878789'
		),
	$controls[] = array(
			'name' => 't_side_linkactive_color',
			'title' => __('Sidebar - Link hover color', 'silesia'),
			'section' => $sections_controls[4], // Top navigation.
			'type' => $control_types[3],
			'selector' => '#sidebar a:hover',
			'selector-mini' => '#sidebar a',
			'color-control' => 't_side_link_color',
			'default' => 'ff0505'
		)		
	);
?>