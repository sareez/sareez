<?php 
get_header();
$t_show_post = nattywp_get_option( "t_show_post" );
?>    

<div class="narrowcolumn">
    <?php if ( have_posts() )
		the_post(); ?>
     
     <h2 class="page-title author"><?php printf( __( '
Author Archives: %s', 'silesia' ), "<span class='vcard'><a class='url fn n' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a></span>" ); ?></h2>

<?php
// If a user has filled out their description, show a bio on their entries.
if ( get_the_author_meta( 'description' ) ) : ?>
					<div id="entry-author-info">
						<div id="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'nattywp_author_bio_avatar_size', 60 ) ); ?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							<h2><?php printf( __( 'About %s', 'silesia' ), get_the_author() ); ?></h2>
							<div class="user-link"><?php the_author_meta( 'user_url' ); ?></div>
							<?php the_author_meta( 'description' ); ?>
						</div><!-- #author-description -->
					</div><!-- #entry-author-info -->
<?php endif; ?>


<?php rewind_posts(); ?>

  <?php if (have_posts()) : ?>
     <?php while (have_posts()) : the_post(); ?>
			<div <?php post_class();?>>
         <div class="post-meta">
          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ms"></a>
          <h5><?php _e('Posted:', 'silesia'); ?></h5>
          <span class="date"><?php the_time('M j, Y') ?></span>
          <?php the_tags('<h5>'.__('Tags:','silesia').'</h5><div class="tags">','','</div>'); ?>
          <h5><?php _e('Comments:', 'silesia'); ?></h5>
          <span class="comment"><?php comments_popup_link(__('0 Comments', 'silesia'), __('1 Comment', 'silesia'), __('% Comments', 'silesia')); ?></span>
          <?php edit_post_link(__('Edit entry','silesia'), '<h5>'.__('Edit','silesia').'</h5>', ''); ?>
         </div>
         
         <div class="p-cont">
           <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
           <div class="entry">
              <?php
                  if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                        the_post_thumbnail('thumbnail');}
                  if ($t_show_post == 'no') {//excerpt
                      the_excerpt();
                  } else { //fullpost
                      t_show_video($post->ID);
                      the_content(); ?>
                  <div id="morepage-list"><?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'silesia' ) . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?></div>
              <?php } ?>
              <div class="clear"></div>
          </div>
        </div><div class="clear"></div>
			</div>
	<?php endwhile; ?>
    
		<div id="navigation">
		<?php nattywp_pagenavi(); ?>
		</div>
        
    <?php else :
		echo '<div class="post">';
		if ( is_category() ) { // If this is a category archive
			printf(__('<h2 class=\'center\'>Sorry, but there aren\'t any posts in the %s category yet.</h2>','silesia'), single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			_e('<h2>Sorry, but there aren\'t any posts with this date.</h2>','silesia');
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf(__('<h2 class=\'center\'>Sorry, but there aren\'t any posts by %s yet.</h2>','silesia'), $userdata->display_name);
		} else {
      _e('<h2 class=\'center\'>No posts found.</h2>','silesia');
		}
		get_search_form();
		echo '</div>';
	endif; ?>
	
 </div> <!-- END Narrowcolumn -->
   <div id="sidebar" class="profile">
     <?php get_sidebar();?>
   </div>
<div class="clear"></div>
<?php get_footer(); ?>