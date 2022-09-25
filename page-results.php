<?php get_header() ?>



<div class="container my-3">

    <div id="wrapper"></div>

    <a href="" class="btn btn-success download-excel" style="display: none;">Download Results</a>
</div>
<?php
$results = new WP_Query([
    'post_type' => 'videoresult',
    'orderby'   => 'title',
    'order'     => 'ASC',
    'post_per_page' => -1,
]);

while ($results->have_posts()) {
    $results->the_post();
    the_ID();
}
?>

<div id="infos" data-url="<?php echo admin_url('admin-ajax.php') ?>"></div>




<?php get_footer();
