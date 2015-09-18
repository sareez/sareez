<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header();?>
        
<div class="narrowcolumn singlepage">
  <div class="post">
    <h2><?php  bloginfo('name'); echo ' '; _e('Sitemap', 'silesia'); ?></h2>
      <div class="entry">
             <h3><?php _e('Pages','silesia'); ?></h3>
             <div class="clear"></div>
              <ul class="arc">
                 <?php wp_list_pages('depth=1&sort_column=menu_order&title_li=' ); ?>
              </ul>
               <br /><br />
              <h3><?php _e('Categories','silesia'); ?></h3>
              <div class="clear"></div>
              <ul class="arc">
                  <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
              </ul>
              <br /><br />

              <?php
                $cats = get_categories();
                foreach ($cats as $cat) {
                  query_posts('cat='.$cat->cat_ID); ?>

              <h3 style="margin-top:10px !important; padding:0px;"><?php echo $cat->cat_name; ?></h3>
              <div class="clear"></div>
              <ul class="arc">
                 <?php while (have_posts()) : the_post(); ?>
                     <li style="font-weight:normal !important;">
                         <a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php _e('Comments','silesia'); ?> (<?php echo $post->comment_count ?>)</li>
                 <?php endwhile;  ?>
              </ul>
              <?php } ?>
              <div class="clear"></div>
      </div>
    </div>
</div> <!-- END Narrowcolumn -->

<div id="sidebar" class="profile">
    <?php get_sidebar();?>
</div>    
<div class="clear"></div>
<?php get_footer(); ?> 