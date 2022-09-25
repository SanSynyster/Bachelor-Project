<?php get_header(); ?>

<div id="advance-compare"></div>
<div id="video_id" video_id='<?php the_ID() ?>' foren='false'></div>
<div id="ajax_url" ajax_url='<?php echo admin_url('admin-ajax.php'); ?>'></div>



<?php
print_pretty($_SESSION['advance_ids']);
if (!isset($_SESSION['advance_ids']) || $_SESSION['advance_ids'] == null or $_SESSION['advance_ids'] == []) {
    ?>
    <script>
        window.location.replace("<?php the_permalink(get_page_by_path('read-me-advance-compare')) ?>");
    </script>
<?php
}
?>

<?php get_footer(); ?>