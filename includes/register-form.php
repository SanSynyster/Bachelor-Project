<?php


// Remove username

add_action('login_head', function () {
    ?>
    <style>
        #registerform>p:first-child {
            display: none;
        }
    </style>

    <script type="text/javascript" src="<?php echo site_url('/wp-includes/js/jquery/jquery.js'); ?>"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#registerform > p:first-child').css('display', 'none');
        });
    </script>
<?php
});



//Remove error for username, only show error for email only.
add_filter('registration_errors', function ($wp_error, $sanitized_user_login, $user_email) {
    if (isset($wp_error->errors['empty_username'])) {
        unset($wp_error->errors['empty_username']);
    }

    if (isset($wp_error->errors['username_exists'])) {
        unset($wp_error->errors['username_exists']);
    }
    return $wp_error;
}, 10, 3);

add_action('login_form_register', function () {
    if (isset($_POST['user_login']) && isset($_POST['user_email']) && !empty($_POST['user_email'])) {
        $_POST['user_login'] = $_POST['user_email'];
    }
});


// add_action('user_register', 'afterRegister');

// function afterRegister($user_id)
// {
//     $password = $_SESSION['password'];
//     wp_set_password($password, $user_id);
//     echo "Your password is: " . $password;
// }


add_action('register_form', 'register_message');
function register_message()
{
    if (!isset($_SESSION['password']))
        $_SESSION['password'] = uniqid();
    echo '
        <div style="margin:10px 0;border:1px solid #e5e5e5;padding:10px">
            <p style="margin:5px 0;">
            Your password will be <span style="color: red">' . $_SESSION['password'] . '</span>
        </p>
        </div>';
}
