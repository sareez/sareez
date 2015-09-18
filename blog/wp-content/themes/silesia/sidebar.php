<ul>
<?php if ( !dynamic_sidebar() ) : ?>
<li class="widget png_scale" id="widget_search">
<?php get_search_form(); ?>
</li>
<li class="widget png_scale" id="widget_categories">
 <h2 class="blocktitle"><span><?php _e('Categories', 'silesia'); ?></span></h2>
 <ul>
<?php wp_list_categories('orderby=name&depth=1&show_count=1&title_li='); ?>
</ul>
</li>
<li class="widget png_scale" id="text_id">
<h2 class="blocktitle"><?php _e('Archive', 'silesia'); ?></h2>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</li>
<li>
    
<li class="widget png_scale" id="meta">
<h2 class="blocktitle"><?php _e('Meta', 'silesia'); ?></h2>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>
<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional', 'silesia'); ?>"><?php _e('Valid', 'silesia'); ?> <abbr title="<?php _e('eXtensible HyperText Markup Language', 'silesia'); ?>"><?php _e('XHTML', 'silesia'); ?></abbr></a></li>
<li class="rss"><?php $t_feedburnerurl = nattywp_get_option('t_feedburnerurl'); if ($t_feedburnerurl == '' || $t_feedburnerurl == 'no') {?>
    <a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Read in RSS', 'silesia'); ?></a>
  <?php } else { ?>
    <a href="<?php echo $t_feedburnerurl ?>"><?php _e('Read in RSS', 'silesia'); ?></a>
   <?php } ?>

</li>
<?php if(nattywp_get_option('t_twitterurl') != '') { ?>
<li class="twitter"><a href="<?php $t_twitterurl = nattywp_get_option('t_twitterurl'); if ($t_twitterurl == 'no') { $t_twitterurl = 'http://twitter.com/nattywp'; } echo $t_twitterurl; ?>" title="<?php _e('Twitter profile', 'silesia'); ?>"><?php _e('Twitter', 'silesia'); ?></a></li>
<?php } ?>
<?php wp_meta(); ?>
</ul>
</li><?php endif; ?> 
</ul>