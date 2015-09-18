<?php 
get_header();
$t_show_post = nattywp_get_option( "t_show_post" ); ?>

<div class="narrowcolumn">
  <?php if (have_posts()) : ?>
      <h1 class="archive-title">
				<?php if ( is_day() ) : ?>
						<?php printf( __( 'Daily Archives: %s', 'silesia' ), '<span>' . get_the_date() . '</span>' ); ?>
				<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Monthly Archives: %s', 'silesia' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'silesia' ) ) . '</span>' ); ?>
				<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Yearly Archives: %s', 'silesia' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'silesia' ) ) . '</span>' ); ?>
				<?php else : ?>
						<?php _e( 'Blog Archives', 'silesia' ); ?>
				<?php endif; ?>
      </h1>
					
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