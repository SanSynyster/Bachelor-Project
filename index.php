<?php get_header(); ?>

<div class="container">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <?php
        while (have_posts()) {
            the_post();
            the_content();
        }
        ?>
    </div>
</div>

<?php get_footer();
