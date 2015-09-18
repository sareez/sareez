<?php 
function natty_themecomment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   switch ( $comment->comment_type ) :
		case '' : ?>

   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">   		
   <div id="comment-<?php comment_ID(); ?>">
   <div class="comment-meta">
    <div class="comment-author vcard">
      <?php echo get_avatar( $comment, $size = '48' ); ?>
      <span class="com-aut"><?php comment_author_link() ?> <?php $test = get_comment_author_url(); ?></span>      
      <a class="c-time" href="<?php the_permalink() ?>#comment-<?php comment_ID() ?>"><?php comment_date('F j, Y') ?> at <?php comment_time() ?></a>
    </div>
   </div>
   <div class="comment-content">
    <?php comment_text() ?>
    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    <div class="clear"></div>
   </div>
  </div>
   <?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'silesia' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'silesia'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
	
} ?>