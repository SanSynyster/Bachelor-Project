<?php


function sahab_enqueue_scripts()
{
    // plyr JS
    wp_enqueue_script('plyr', 'https://cdnjs.cloudflare.com/ajax/libs/plyr/3.6.12/plyr.min.js', [], 1.2, false);
    wp_enqueue_style('plyr', 'https://cdnjs.cloudflare.com/ajax/libs/plyr/3.6.12/plyr.min.css', [], 1.2);

    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css', [], time());
    wp_enqueue_style('style-a', get_stylesheet_directory_uri() . '/src/AdvanceVideoResult/dist/style.css', [], time());

    wp_enqueue_script('functions',  get_stylesheet_directory_uri() . '/assets/functions.js', [], 1.1);

    // theme
    // wp_enqueue_style('main',  get_stylesheet_directory_uri() . '/assets/dist/style.min.css', [], 1.1);
    if (get_post_type() == 'video') {

        wp_enqueue_script('video',  get_stylesheet_directory_uri() . '/templates/video/video.js', [], 1.1, true);

        // 
    } else if (get_post_type() == 'compare-video') {

        wp_enqueue_script('compare-video',  get_stylesheet_directory_uri() . '/templates/compare-video/compare-video.js', [], 1.1, true);

        // 
    } else if (is_page("results")) {

        wp_enqueue_script('results',  get_stylesheet_directory_uri() . '/templates/results/results.js', [], 1.1, true);

        // 
    } else if (is_page("compare-results")) {

        wp_enqueue_script('compare-results',  get_stylesheet_directory_uri() . '/templates/compare-results/compare-results.js', [], 1.1, true);

        // 
    }

    if (!is_user_logged_in() or true) {
        wp_enqueue_script('login',  get_stylesheet_directory_uri() . '/templates/auth/login.js', [], 1.1, true);
        wp_enqueue_script('register',  get_stylesheet_directory_uri() . '/templates/auth/register.js', [], 1.1, true);

        // 
    }

    wp_enqueue_script('advance-compare-react', get_stylesheet_directory_uri() . '/build/index.js', ['wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor'], 2.3, true);


    // wp_enqueue_script('hossein-phone-validation',  get_stylesheet_directory_uri() . '/includes/js/phoneValidation.js', [], 1.1);
    // wp_enqueue_script('hossein-email-validation',  get_stylesheet_directory_uri() . '/includes/js/emailValidation.js', [], 1.1);
}

add_action('wp_enqueue_scripts', 'sahab_enqueue_scripts');


function register_session()
{
    if (!session_id())
        session_start();
}
add_action('init', 'register_session');




add_action('init', 'custom_login');
function custom_login()
{
    if (!isCurrentUserAdmin()) {

        global $pagenow;
        //  URL for the HomePage. You can set this to the URL of any page you wish to redirect to.
        $blogHomePage = get_bloginfo('url');
        if (strpos($blogHomePage, ".com") or strpos($blogHomePage, ".ir")) {

            //  Redirect to the Homepage, if if it is login page. Make sure it is not called to logout or for lost password feature
            if ('wp-login.php' == $pagenow) {
                wp_redirect($blogHomePage);
                exit();
            }
        }
    }
}


function print_pretty($arg)
{
    ?>
    <script>
        print_pretty.push(<?php echo json_encode($arg, JSON_HEX_TAG); ?>); // Don't forget the extra semicolon!
        console.log(print_pretty[print_pretty.length - 1])
    </script>
<?php
}


function getUserFullName($user_id)
{
    $current_user = get_user_by("ID", $user_id);
    $full_name = $current_user->display_name;
    // print_pretty($full_name);
    if ($full_name == "") {
        $full_name = $current_user->first_name . " " . $current_user->last_name;
        if ($full_name == "" or $full_name == " ") {
            $full_name = $current_user->user_nicename;
            if ($full_name == "") {
                $full_name = $current_user->nickname;
                if ($full_name == "") {
                    $full_name = $current_user->user_email;
                    if ($full_name == "") {
                        $full_name = $current_user->user_login;
                        if ($full_name == "") {
                            $full_name = "بی نام";
                        }
                    }
                }
            }
        }
    }
    return $full_name;
}


if (!function_exists('write_log')) {
    function write_log($log)
    {
        if (is_array($log) || is_object($log)) {
            error_log(print_r($log, true));
        } else {
            error_log($log);
        }
    }
}

function register_my_session()
{
    if (!session_id()) {
        session_start();
    }
}

add_action('init', 'register_my_session');


// Listen for publishing of a new post
function send_new_post($post_id)
{
    update_post_meta($post_id, 'views', get_post_meta($post_id, 'views', true) ?? 1);
}
add_action('publish_advance-compare', 'send_new_post', 10, 3);

require get_theme_file_path('/allRequires.php');


add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
