<?php
if (is_user_logged_in()) { ?>
    <script>
        window.location.replace("<?php echo get_site_url() ?>");
    </script>
<?php }
?>

<div id="register"></div>



<div id="infos" data-url="<?php echo admin_url('admin-ajax.php') ?>" thum="<?php the_post_thumbnail_url() ?>" login_url="<?php echo get_site_url() . '/login' ?>"></div>



<style>
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    .h-custom {
        height: calc(100% - 73px);
    }

    @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
    }
</style>