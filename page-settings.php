<?php
get_header();

if (isCurrentUserAdmin() && isset($_GET['sure']) && $_GET['sure'] == 'true') {

    $posts = new WP_Query([
        'post_type' =>  'any',
        'posts_per_page' => -1,
    ]);

    while ($posts->have_posts()) {
        $posts->the_post();
        update_post_meta(get_the_ID(), 'views', 1);
    }

    echo 'done';
} ?>

<a href="?sure=true" class="btn btn-warning">Set All Views To 1</a>

<?php get_footer();
