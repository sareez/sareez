<form method="get" id="searchforma" class="search" action="<?php echo home_url(); ?>/">
    <input type="text" class="search-input png_crop" title="search" value="<?php _e('Search','silesia'); ?>" onblur="if (!value)value='<?php _e('Search','silesia'); ?>'" onclick="value=''" id="edit-search-theme-form-keys" name="s" />
    <input type="image" alt="<?php _e('Search','silesia'); ?>" title="Search" class="search-submit png_crop" name="op" value="" src="<?php echo get_template_directory_uri();?>/images/submit.png"/>
</form><div style="clear:both;"></div>