<?php get_header(); ?>



<div class="container" style="height: 100vh;">
    <?php
    $firstCustomVideo = get_posts([
        'post_type' => 'video',
        'posts_per_page' => 1,
        'order' => 'ASC',
        'meta_key'        => 'custom_or_fixed',
        'meta_value'    => '1'
    ])[0];
    ?>

    <div class="d-flex flex-column justify-content-center align-items-center h-100">

        <a href="<?php echo get_the_permalink($firstCustomVideo) ?>" class="btn btn-info btn-lg mb-4 w-100 w-md-50 d-none">
            Enter Custom Video Test
        </a>

        <?php if (!get_field('finished_advance_compare_test', wp_get_current_user()) or true) :
            // For hiding advance compare after finish just delete "or true" from this if
            ?>

            <a href="<?php the_permalink(get_page_by_path('read-me-advance-compare')) ?>" class="btn btn-success btn-lg mb-4 w-100 w-md-50">
                Enter Test
            </a>
            <a href="<?php the_permalink(get_page_by_path('read-me-advance-compare-foreigner')) ?>" class="btn btn-success btn-lg mb-4 w-100 w-md-50">
                Enter Test (Foreigners)
            </a>

        <?php endif ?>

        <?php if (!get_field('finished_fixed_test', wp_get_current_user())) : ?>

            <a href="<?php the_permalink(get_page_by_path('read-me-fixed')) ?>" class="btn btn-warning btn-lg mb-4 w-100 w-md-50 d-none">
                Enter Fixed Video Test
            </a>
        <?php endif ?>

        <?php if (!get_field('finished_compare_test', wp_get_current_user()) and false) : ?>

            <a href="<?php the_permalink(get_page_by_path('read-me-compare-test')) ?>" class="btn btn-danger btn-lg w-100 w-md-50">
                Enter Compare Video Test
            </a>
        <?php endif ?>
    </div>

</div>

<?php get_footer();
