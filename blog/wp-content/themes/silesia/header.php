<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'silesia' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="author" href="https://plus.google.com/u/1/113697578259726428578/posts"/>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php 
  $t_show_slideshow = nattywp_get_option("t_show_slideshow");
  $t_scroll_pages = nattywp_get_option("t_scroll_pages");
  $t_hide_tagline = nattywp_get_option("t_hide_tagline");
  $t_hide_social = nattywp_get_option("t_hide_social");
  $t_twitterurl = nattywp_get_option("t_twitterurl");
  $t_facebookurl = nattywp_get_option("t_facebookurl");
  $t_feedburnerurl = nattywp_get_option("t_feedburnerurl");
?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="main-nav">
  <div id="link-sidebar">
    <ul>
      <?php if ( !dynamic_sidebar(3) ) : ?>
        <?php if(current_user_can('edit_themes')) : ?>
        <li class="widget png_scale" id="widget_text"><h2 class="blocktitle"><span><?php _e('Welcome', 'silesia'); ?></span></h2>
          <div class="textwidget"><?php _e('Welcome to <strong>Silecia theme.</strong> This area is completely widgetized.', 'silesia'); ?></div>
        </li>
        <?php endif; ?>
        <li class="widget png_scale" id="widget_categories">
          <h2 class="blocktitle"><span><?php _e('Categories', 'silesia'); ?></span></h2>	
          <ul>
              <?php wp_list_categories('orderby=name&depth=1&show_count=0&title_li='); ?>
          </ul>		
        </li>
        <?php if(!is_active_widget(true, 'twitter-1', 'sidebar-1')) { ?>
        <li id="twitterWidget" class="widget png_scale">	
          <div id="twitter">
            <h2 class="blocktitle"><span><?php _e('Twitter Updates', 'silesia'); ?></span></h2>		<ul id="twitter_update_list"><li></li></ul>
            <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
            <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/nattywp.json?callback=twitterCallback2&amp;count=1"></script>
            <div class="dasheddivider"></div>
            <p align="right"><a href="http://www.twitter.com/nattywp/" class="rightlink png_crop"><?php _e('Follow us on Twitter', 'silesia'); ?></a></p>
        </div>
        </li>   
       <?php } endif; ?>     
    </ul>
  </div>
  <a id="control" href="#">+</a>
</div>

<div id="main-wrapper">
<div id="header">
  <div class="wrapper">
    <div class="triangle"></div>
    <div class="logo-block">
    <div class="logo">
    <?php if (nattywp_get_option( "nattywp_custom_logo" ) == ''){
       echo '<ul><li><a class="logo-title shadowed" href="'.home_url().'" rel="home" title="'.esc_attr(get_bloginfo('name', 'display')).'">'.get_bloginfo('name', 'display').'</a></li></ul>';
    } else { ?>        
       <a href="<?php echo home_url(); ?>"><?php nattywp_get_logo ('', '', 'px.gif', false); ?></a>
    <?php } ?> 
    </div>
  <?php if(!isset($t_hide_tagline) || $t_hide_tagline == 'no') {
    echo '<div class="tagline">'.get_bloginfo('description').'</div>';
  } ?></div>
  
<?php /*?>  <?php if(!isset($t_hide_social) || $t_hide_social == 'no') { ?><?php */?>
  <ul class="social">
 <li><a href="https://www.facebook.com/Sareez"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook-icon.jpg" alt="<?php bloginfo('name'); ?>" border="0" /></a> </li>
					<li><a href="https://twitter.com/Sareez"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter-icon.jpg" alt="<?php bloginfo('name'); ?>" border="0" /></a></li>
					<li><a href="https://plus.google.com/+Sareez/posts"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/gplus-iocn.jpg" alt="<?php bloginfo('name'); ?>" border="0" /></a> </li>
                	<li><a href="https://www.pinterest.com/senoritasareez"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/printrest-icon.jpg" alt="<?php bloginfo('name'); ?>" border="0" /></a> </li>
                	
    <?php /*?><?php if ($t_feedburnerurl != '' && $t_feedburnerurl != 'no') {?>
      <li id="rss"><a class="ss png_crop" href="<?php echo $t_feedburnerurl; ?>"></a></li>
    <?php } else { ?>
      <li id="rss"><a class="ss png_crop" href="<?php bloginfo('rss2_url'); ?>"></a></li>
    <?php } ?>
    <?php if($t_facebookurl != ''){ if($t_facebookurl == 'no') $t_facebookurl = 'http://www.facebook.com/Sareez';?><li id="fb"><a class="ss png_crop" href="<?php echo $t_facebookurl; ?>"></a></li><?php } ?>
    <?php if($t_twitterurl != ''){ if($t_twitterurl == 'no') $t_twitterurl = 'http://twitter.com/sareez';?><li id="tw"><a class="ss png_crop" href="<?php echo $t_twitterurl; ?>"></a></li><?php } ?>
  </ul>
  <?php } ?><?php */?>
  </ul>
  <div class="clear"></div>
  </div>
</div>

<div id="cnt" class="wrapper">
  <div class="top">
<?php /*?>    <?php 
      if(nattywp_get_option("t_head_nav") == 'nav') {
        silesia_show_navigation ('primary', 'silesia_show_pagemenu'); 
      } else {
        silesia_breadcrumbs();
      } ?><?php */?>
      <?php wp_nav_menu( array( 'menu_class' => '', 'theme_location' => 'primary' ) ); ?>
      
    <div class="clear"></div>            
  </div> <!-- END top -->


<?php
  if ($t_show_slideshow == 'hide') {}
  elseif ($t_show_slideshow == 'pag' || !isset($t_show_slideshow) || $t_show_slideshow == 'no') { // Display Slideshow ?>
  <div class="head-img">
  <div class="slideshow-bg module">
    <a id="left-arrow" href="#"></a>
    <a id="right-arrow" href="#"></a>
    <div class="slideshow">
      <?php if ($t_scroll_pages == 'no' || $t_scroll_pages[0] == 'no' || $t_scroll_pages[0] == ''){
        echo '<div><img src="'.get_template_directory_uri().'/images/header/banner04.jpg" alt="Header" /></div>';
        echo '<div><img src="'.get_template_directory_uri().'/images/header/banner03.jpg" alt="Header" /></div>';
      } else {
        foreach ($t_scroll_pages as $ad_pgs ) { 
         query_posts('page_id='.$ad_pgs ); while (have_posts()) : the_post(); ?>
         <div><?php if ( has_post_thumbnail() ) {the_post_thumbnail('slide-thumb');} // 970x225 ?></div>
         <?php endwhile; wp_reset_query();
        } //end foreach 
      } ?>  
    </div><!-- END Slideshow -->
  </div> <!-- END slideshow-bg -->
  </div>
  <?php } else { // Display Header Image
    $header_image = get_header_image();
    if ( !empty( $header_image ) ) : ?>
      <div class="head-img">
      <img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="Header" />
      </div>
    <?php endif;
  } // End if ?>
<!-- END Header -->