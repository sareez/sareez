<?php get_header();?>
<div class="narrowcolumn singlepage">
   <?php if (have_posts()) : ?>
     <?php while (have_posts()) : the_post(); ?>
      <div <?php post_class();?>>
         <div class="post-meta">
          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ms"></a>
          <h5><?php _e('Posted:', 'silesia'); ?></h5>
          <span class="post_date date updated"><?php the_time('j F,Y'); ?></span>
          <?php the_tags('<h5>'.__('Tags:','silesia').'</h5><div class="tags">','','</div>'); ?>
          <h5><?php _e('Comments:', 'silesia'); ?></h5>
          <span class="comment"><?php comments_popup_link(__('0 Comments', 'silesia'), __('1 Comment', 'silesia'), __('% Comments', 'silesia')); ?></span>
          <?php edit_post_link(__('Edit entry','silesia'), '<h5>'.__('Edit','silesia').'</h5>', ''); ?>
         </div>
         
         <div class="p-cont">
           <h1 class="title single-title entry-title"> <?php the_title(); ?></h1>
           			<span class="vcard author">
<span class="fn"> by <?php the_author(); ?></span>
</span>
            <div class="entry">
              <?php t_show_video($post->ID); ?>
              <?php the_content(); ?>
              <div class="clear"></div>
              <?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'silesia' ) . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
              <?php
                $categories_list = get_the_category_list( __( ', ', 'silesia' ) );
                if($categories_list != '')
                  echo '<p class="inner-meta">'.sprintf( __( 'This entry was posted in %s', 'silesia' ), $categories_list).'</p>';
              ?>
              
            </div>
              <div class="post comments" id="comments">              
                <?php comments_template(); ?>
               <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
              </div>
               
          </div>
       </div>
  <?php endwhile; ?>
  <?php else : ?>
    <div class="post">
       <h2><?php _e('Not Found','silesia'); ?></h2>
       <div class="entry"><p><?php _e('Sorry, but you are looking for something that isn\'t here.','silesia'); ?></p>
          <?php get_search_form(); ?>
       </div>
     </div>
  <?php endif; ?>

</div> <!-- END Narrowcolumn -->

<div id="sidebar" class="profile">
 <?php if (!is_active_sidebar(2)) {
        get_sidebar(); 
    } else {
        echo '<ul>';
        dynamic_sidebar('sidebar-2');
        echo '</ul>';
    } ?>
</div>
<div class="clear"></div>
<?php get_footer(); ?>