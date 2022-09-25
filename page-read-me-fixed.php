<?php get_header(); ?>


<?php if (!get_field('finished_fixed_test', wp_get_current_user())) :
    $fixedVideos = get_posts([
        'post_type' => 'video',
        'posts_per_page' => 15,
        'fields' => 'ids',
        'order' => 'ASC',
        'meta_key'        => 'custom_or_fixed',
        'meta_value'    => '0'
    ]);
    $next_video_id = $fixedVideos[0];
    if (get_field('last_video_reviewed', wp_get_current_user())) {
        $index = -1;
        for ($i = 0; $i < count($fixedVideos); $i++) {
            if (
                $fixedVideos[$i] == get_field('last_video_reviewed', wp_get_current_user())
                and ($i + 1) < count($fixedVideos)
            ) {
                $index = $i + 1;
                break;
            }
        }

        if ($index and $index != -1) {
            $next_video_id = $fixedVideos[$index];
        }
    }
    ?>

    <div class="container">
        <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
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
