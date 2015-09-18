<?php
/**
 * Custom theme Hooks.
 */
 
if (!isset($content_width))
	$content_width = 590;

add_action( 'after_setup_theme', 'silesia_setup' );

if ( ! function_exists( 'silesia_setup' ) ):
  function silesia_setup() {
    // Localization
    load_theme_textdomain( 'silesia', get_template_directory() . '/languages' );
    
    $locale = get_locale();
    $locale_file = get_template_directory() . "/languages/$locale.php";
    if ( is_readable( $locale_file ) )
      require_once( $locale_file );
    
    /*
     * Theme Extension
     */
     add_editor_style();
     add_theme_support('automatic-feed-links');
     add_theme_support('post-formats', array('image', 'link', 'quote', 'video', 'audio'));
     add_theme_support('post-thumbnails');
     add_image_size('slide-thumb', 980, 150, true); //(cropped)
     add_custom_background(); // Add support for custom backgrounds
     
     register_nav_menu( 'primary', __( 'Primary Menu', 'silesia' ) );

    // Custom Header
      //define( 'HEADER_TEXTCOLOR', '333333' );
      define('NO_HEADER_TEXT', true );
      if (get_option('silesia_custom_header') != '') {
        define('HEADER_IMAGE', get_option('silesia_custom_header')); // %s is the template dir uri
      } else {
        define ('HEADER_IMAGE', '');}
      define ('HEADER_IMAGE_WIDTH', apply_filters( 'silesia_header_image_width', 980 ));
      define ('HEADER_IMAGE_HEIGHT', apply_filters( 'silesia_header_image_height', 150 ));

      add_theme_support( 'custom-header', array( 'random-default' => true ) ); // Enable Random
      add_custom_image_header ('', 'silesia_admin_header_style', 'silesia_admin_header_image');
      register_default_headers (array(
          'blue' => array(
            'url' => '%s/images/header/headers.jpg',
            'thumbnail_url' => '%s/images/header/headers-thumbnail.jpg',
            'description' => __('Blue', 'silesia')
          ),
          'green' => array(
            'url' => '%s/images/header/header.jpg',
            'thumbnail_url' => '%s/images/header/header-thumbnail.jpg',
            'description' => __('Green', 'silesia')
          ),
        ));
  }
endif; // silesia_setup


function silesia_styles() {
 	wp_register_style('default', get_bloginfo('stylesheet_url'), array(), NULL);
 	wp_register_style('silesia-ie7', get_template_directory_uri().'/ie7.css', array(), NULL);
 	wp_register_style('silesia-ie6', get_template_directory_uri().'/ie6.css', array(), NULL);
  wp_enqueue_style('default');
  wp_enqueue_style('silesia-ie7');
  wp_enqueue_style('silesia-ie6');
  
  global $wp_styles;
  $wp_styles->add_data('silesia-ie7', 'conditional', 'IE 7');
  $wp_styles->add_data('silesia-ie6', 'conditional', 'IE 6');
} 
add_action('wp_print_styles', 'silesia_styles'); // styles


function silesia_direct_styles() { 
  include (get_template_directory() . '/style.php');
  echo '<style type="text/css">
    #header .triangle {border-left: 7px solid #'.nattywp_get_coptions('t_slide_background_color').';}
  </style>';
}
add_action('wp_head', 'silesia_direct_styles'); // direct styles


function silesia_scripts() {
  wp_enqueue_script("jquery");
	if (is_singular() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	wp_register_script('cycle', get_template_directory_uri().'/js/jquery.cycle.all.min.js', array('jquery'), NULL);
	wp_register_script('silesia_load', get_stylesheet_directory_uri() . '/js/load.js', array('jquery'), NULL);
	
	wp_enqueue_script('cycle');
	wp_enqueue_script('silesia_load');
}
add_action('wp_enqueue_scripts', 'silesia_scripts'); // scripts


function silesia_direct_scripts() {
  echo '<!--[if IE 6]>
    <script type="text/javascript" src="'.get_template_directory_uri().'/js/ie6/warning.js"></script>
    <script type="text/javascript" charset="utf-8">/*<![CDATA[*/window.onload=function(){e("'.get_template_directory_uri().'/js/ie6/")}/*]]>*/</script>
<![endif]-->';
}
add_action('wp_head', 'silesia_direct_scripts'); // direct scripts


function silesia_footer() {
  $t_tracking = nattywp_get_option( "t_tracking" );
  if($t_tracking == 'no'){}
  else {
    if ($t_tracking != "")
      echo stripslashes(stripslashes($t_tracking));
  }
  // Slideshow
  if (nattywp_get_option('t_show_slideshow') == 'pag' || !isset($t_show_slideshow) || $t_show_slideshow == 'no') {
    $t_timeout = nattywp_get_option('t_timeout');  
    $t_slide_speed = nattywp_get_option('t_slide_speed'); 
    $t_slide_effect = nattywp_get_option('t_slide_effect');
    if(!isset($t_slide_effect) || $t_slide_effect == 'no') {$t_slide_effect = 'turnDown';}
    if(!isset($t_timeout) || $t_timeout == 'no') {$t_timeout = '5000';}
    if(!isset($t_slide_speed) || $t_slide_speed == 'no') {$t_slide_speed = '1000';}
    echo '<script type="text/javascript" charset="utf-8">/*<![CDATA[*/ 
    jQuery(document).ready(function() {
        jQuery(".slideshow").cycle({
          fx: "'.$t_slide_effect.'",
          timeout: '.$t_timeout.',
          speed: '.$t_slide_speed.',
          prev: "#left-arrow",
          next: "#right-arrow",
          pagerEvent: "click",
          pauseOnPagerHover: true,
          cleartypeNoBg: true });						
      });
      /*]]>*/</script>';
  }
}
add_action('wp_footer', 'silesia_footer');


if ( !function_exists( 'silesia_admin_header_style')) :
  function silesia_admin_header_style() { ?>
	<style type="text/css">
    .appearance_page_custom-header #headimg {border: none; width:970px;}
    #headimg {position:relative; background:#f7f7f7;}
    #headimg img {max-width:980px; height: auto; width: 100%;}
	</style>
<?php
}
endif; // silesia_admin_header_style

if ( !function_exists('silesia_admin_header_image')) :
  function silesia_admin_header_image() { ?>
    <div id="headimg">    
      <?php $header_image = get_header_image();
      if ( ! empty( $header_image ) ) : ?>
        <img src="<?php echo esc_url( $header_image ); ?>" alt="Header" />
      <?php endif; ?>
    </div>
  <?php }
endif; // silesia_admin_header_image

if (is_admin() && isset($_GET['page'] )) {
    if ($_GET['page'] == 'custom-header' && (nattywp_get_option("t_show_slideshow") != 'yes')) 
    echo '<div id="message4" class="updated" style="border:1px solid #c43;">'. __('<p><strong>Note:</strong> The Custom Header is currently disabled. You should get back to Theme Options and configure Header Area Settings. To do this, open <a href="?page=nattywp_home">Theme Options</a> select <strong>Front Page Settings</strong> tab and choose <strong>Display Header Image</strong> value from drop down list.</p>.', 'silesia').'</div>';
}
// END Custom Header


function silesia_seo_title($orig_title) {
   if(is_single() || is_page()) {
     global $post;
     $custom_title = get_post_meta($post->ID, 'natty_title', true);
     
     if (strlen($custom_title)) {
        return strip_tags(stripslashes($custom_title)).' | ';      
     } else {
        return $orig_title;
     }
   }
}
add_filter('wp_title', 'silesia_seo_title');

function silesia_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'silesia_page_menu_args' );


function silesia_continue_reading_link() {
	return '<br/><a class="more-link" href="'. get_permalink() . '">' . __( 'Read more <span class="meta-nav">&rarr;</span>', 'silesia' ) . '</a>';
}
function silesia_auto_excerpt_more( $more ) {
	return ' &hellip;' . silesia_continue_reading_link();
}
function silesia_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= silesia_continue_reading_link();
	}
	return $output;
}
add_filter( 'excerpt_more', 'silesia_auto_excerpt_more' );
add_filter( 'get_the_excerpt', 'silesia_custom_excerpt_more' );


function silesia_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'silesia_remove_gallery_css' );


function silesia_show_navigation($args, $func) {
  wp_nav_menu( array( 'container' => '', 'menu_class' => 'topnav fl fr sf-js-enabled sf-shadow', 'menu_id' => 'nav-ie', 'theme_location' => $args, 'link_before' => '<span>', 'link_after' => '</span>', 'fallback_cb' => $func ) );
}


function silesia_get_profile() {
	printf( __( '%1$s', 'silesia' ),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'silesia' ), get_the_author() ),
			get_the_author()
		)
	);
}

function silesia_breadcrumbs() {
  $delimiter = '&raquo;'; // delimiter between crumbs
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  global $post;
  $homeLink = home_url();
  if (nattywp_get_option('t_home_name') == 'no')
    $homeName = 'Home';
  else 
    $homeName = nattywp_get_option('t_home_name');
  $output = '<ul id="crumbs">';
 
  if (is_home() || is_front_page()) {
    $output.='<li class="first"><a href="'.$homeLink.'" id="home-img"></a></li>';
    $output.='<li>'.$homeName.'</li>';
  } else {
    $output.='<li class="first"><a href="'.$homeLink.'" id="home-img"></a></li>';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) 
        $output.= '<li>'.get_category_parents($parentCat, TRUE, ' &raquo; ').'</li>';
      $output.= '<li>'. __('Archive by category', 'silesia').' "' . single_cat_title('', false) . '"' . '</li>';
      
    } elseif ( is_day() ) {
      $output.= '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
      $output.= '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li>';
      $output.= '<li>' . get_the_time('d') . '</li>';
 
    } elseif ( is_month() ) {
      $output.= '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
      $output.= '<li>'. get_the_time('F') . '</li>';
 
    } elseif ( is_year() ) {
      $output.= '<li>' . get_the_time('Y') . '</li>';
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        $output.= '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
        $output.= '<li>' . get_the_title() . '</li>';
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $output.= '<li>'. get_category_parents($cat, TRUE, ' &raquo; ') .'</li>';
        $output.= '<li>'. get_the_title() .'</li>';
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      if(isset($post_type->labels))
        $output.= '<li>'. $post_type->labels->singular_name .'</li>';
      else 
        $output.= '<li>'. __('Nothing to display', 'silesia') .'</li>'; 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      $output.= '<li>'.get_category_parents($cat, TRUE, ' &raquo; ').'</li>';
      $output.= '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
      $output.= '<li>'. get_the_title() .'</li>';
 
    } elseif ( is_page() && !$post->post_parent ) {
      $output.= '<li>'. get_the_title() .'</li>';
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) 
        $output.= $crumb;
      $output.= '<li>'.get_the_title().'</li>';
 
    } elseif ( is_search() ) {
      $output.= '<li>'.__('Search results for', 'silesia').' "' . get_search_query() . '"</li>';
 
    } elseif ( is_tag() ) {
       $output.= '<li>'.__('Posts tagged', 'silesia').' "' . single_tag_title('', false) . '"</li>';
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      $output.= '<li>'.__('Articles posted by', 'silesia').' ' . $userdata->display_name . '</li>';
 
    } elseif ( is_404() ) {
      $output.= '<li>'.__('Error 404', 'silesia').'</li>';
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $output.= ' (';
      $output.=  __('Page', 'silesia') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $output.= ')';
    }
 
  }
  $output .= '</ul>';
  echo $output;
}

function silesia_show_pagemenu () {
	$pages = wp_list_pages('sort_column=menu_order&title_li=&echo=0&depth=0');
	$pages = preg_replace('%<a ([^>]+)>%U','<a $1><span>', $pages);
	$pages = str_replace('</a>','</span></a>', $pages);
	echo '<ul id="nav-ie" class="topnav fl fr sf-js-enabled sf-shadow">'.$pages.'</ul>';
}
?>