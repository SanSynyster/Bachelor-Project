<?php get_header(); ?>


<?php if (!get_field('finished_compare_test', wp_get_current_user())) :
    $videos = get_posts([
        'post_type' => 'advance-compare',
        'posts_per_page' => 15,
        'fields' => 'ids',
        'meta_key' => 'views',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
    ]);
    $next_video_id = $videos[0];

    $_SESSION['advance_ids'] = $videos;
    print_pretty($_SESSION['advance_ids']);
    ?>

    <div class="container">
        <div class="d-flex flex-column justify-content-center " style="min-height: 100vh;">
            <?php
                while (have_posts()) {
                    the_post();
                    the_content();
                    ?>

                <?php if (current_user_can('administrator')) : ?>
                    <a href="<?php echo get_edit_post_link(get_the_ID()) ?>">Edit this text</a>
                <?php endif ?>

            <?php  } ?>

            <a href="<?php echo get_the_permalink($next_video_id) ?>" class="btn btn-success btn-lg mt-4">
                Continue
            </a>
        </div>
    </div>

<?php endif ?>



<?php get_footer();
