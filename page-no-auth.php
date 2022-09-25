<?php get_header() ?>
<div id="no_auth"></div>
<div id="infos" login_url='<?php echo get_site_url() . "/login" ?>' register_url='<?php echo get_site_url() . "/register" ?>' logo='<?php echo get_the_post_thumbnail_url() ?>' text='<?php the_content() ?>'></div>
<?php get_footer() ?>