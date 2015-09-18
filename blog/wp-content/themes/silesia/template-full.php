<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?> 

<div class="narrowcolumn singlepage fullwidth">
     <?php if (have_posts()) : ?>
     <?php while (have_posts()) : the_post(); ?>
      <div class="post">
        <h2><?php the_title(); ?></h2>
          <div class="entry">
             <?php t_show_video($post->ID); ?>
             <?php the_content(); ?>
             <div class="clear"></div>
          </div>
        <p class="postmetadata">
            <?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'silesia' ) . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?> <?php edit_post_link(__('Edit','silesia'), '<p>', '</p>'); ?>
        </p>
      </div>
    <?php endwhile; ?>
    <?php endif; ?>
</div> <!-- END Narrowcolumn -->

<div class="clear"></div>
<?php get_footer(); ?>