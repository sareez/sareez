<?php get_header(); ?>
<div class="narrowcolumn singlepage">
			<div class="post">
          <h2><?php _e('Error 404','silesia'); ?></h2></div>
          <div class="entry">
             <p><?php _e('It appears you\'ve missed you\'re intended destination, either through a bad or outdated link, or a typo in the page you were hoping to reach.','silesia'); ?></p>
             <p><strong><?php _e('You can take a look through my recent posts.','silesia'); ?></strong></p>
             <?php query_posts('showposts=15'); ?>
             <?php while (have_posts()) : the_post(); ?>
                 <ul class="arc">
                    <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
                 </ul>
             <?php endwhile;?>
             <div class="clear"></div>
				</div>
			</div>
            <div id="sidebar" class="profile">
   <?php if (!is_active_sidebar(2)) {
    get_sidebar(); 
} else {
    echo '<ul>';
    dynamic_sidebar('sidebar-2');
    echo '</ul>';
} ?>
   </div>
</div> <!-- END Narrowcolumn -->



<div class="clear"></div>
<?php get_footer(); ?>
