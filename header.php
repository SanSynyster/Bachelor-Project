<!DOCTYPE html>
<html lang="en" class="">

<?php
if (!is_user_logged_in() and !(is_page("login") or is_page('register') or is_page('no-auth'))) {
    wp_redirect('/no-auth');
} ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?><?php wp_title('&raquo;', 'true', 'left'); ?></title>
    <?php wp_head() ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.17.2/video.min.js" integrity="sha512-KZaZOuEgOUqgiHUpO74Ye5fw+ReH2KOeeKE5gI2IqJMeoVFAm3YfYJgOsRd1dks+gS9U4UCrSaU5TGR1yiYCUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.17.2/video-js.min.css" integrity="sha512-d4c0djrxPfHtfWvKxxUpyL7jQxHfXf8ijfTcmbK9NZUYpl/Bclwj5SlWDpjxJfq1ah1JAqyFj8T00DmxiX+LJw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" /> -->

    <!-- <script src="https://unpkg.com/jquery/dist/jquery.min.js"></script> -->
    <script src="https://unpkg.com/gridjs-jquery/dist/gridjs.production.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" />
</head>



<?php
if (is_page('results') and !current_user_can('administrator')) {
    wp_die("You don't have access to this section. <a href='" . get_site_url() . "'>Go Home</a>");
}
?>

<body class="">
    <?php if (current_user_can('administrator')) : ?>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?php echo site_url() ?>">Home</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav w-100 mb-2 mb-lg-0">
                        <?php if (current_user_can('administrator')) : ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php the_permalink(get_page_by_path('results')) ?>">Results</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php the_permalink(get_page_by_path('compare-results')) ?>">Compare Video Results</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php the_permalink(get_page_by_path('advance-results')) ?>">Advance Compare Results</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php echo get_the_permalink(get_page_by_path('advance-results')) . '?foren=true'  ?>">Advance Compare Results Foreigner</a>
                            </li>
                        <?php endif;
                            if (!is_user_logged_in()) : ?>

                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php the_permalink(get_page_by_path('login')) ?>">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php the_permalink(get_page_by_path('register')) ?>">Register</a>
                            </li>

                        <?php else : ?>

                            <li class="nav-item ms-lg-auto">
                                <a class="nav-link active logout" aria-current="page" href="#">Logout</a>
                            </li>

                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>

    <?php endif ?>

    <div id="infos-header" data-url="<?php echo admin_url('admin-ajax.php') ?>"></div>