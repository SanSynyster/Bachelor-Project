<?php


add_action('wp_ajax_nopriv_register', 'registerUserAjax');

function registerUserAjax()
{
    if (!isset($_REQUEST["name"]) or !isset($_REQUEST["email"]) or !isset($_REQUEST["password"]) or !isset($_REQUEST["age"]) or !isset($_REQUEST["gender"])) {
        wp_send_json_error([
            "message" => "Please enter all fields"
        ]);
    }

    $name = $_REQUEST["name"];
    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
    $age = $_REQUEST["age"];
    $gender = $_REQUEST["gender"];
    $connection_type = $_REQUEST["connection_type"];

    if ($name == "" or $email == "" or $password == "" or $age == "" or $gender == "" or $connection_type == "") {
        wp_send_json_error([
            "message" => "Please enter all fields"
        ]);
    }


    $user_id = wp_insert_user([
        "user_email" => $email,
        "user_login" => $email,
        "user_pass" => $password,
        "display_name" => $name,
    ]);


    if (is_wp_error($user_id)) {
        wp_send_json_error([
            "message" => $user_id->get_error_message(),
        ]);
    }

    update_field('gender', $gender,  "user_" . $user_id);
    update_field('age', $age, "user_" . $user_id);
    update_field('connection_type', $connection_type, "user_" . $user_id);

    $user = get_user_by('ID', $user_id);

    $info = [
        'user_login' => $user->user_login,
        'user_password' => $password,
        'remember' => true
    ];

    $user_signon = wp_signon($info, false);


    if (is_wp_error($user_signon)) {
        wp_send_json_error([
            "message" => "Please check your inputs",
            'error' => $user_signon
        ]);
    }

    wp_send_json_success(["message" => "Loging in ..."]);
}

add_action('wp_ajax_nopriv_login', 'loginUserAjax');

function loginUserAjax()
{
    if (!isset($_REQUEST["email"]) or !isset($_REQUEST["password"])) {
        wp_send_json_error([
            "message" => "Please enter all fields"
        ]);
    }

    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];

    if ($email == "" or $password == "") {
        wp_send_json_error([
            "message" => "Please enter all fields"
        ]);
    }


    $user = get_user_by('email', $email);

    $info = [
        'user_login' => $user->user_login,
        'user_password' => $password,
        'remember' => true
    ];

    $user_signon = wp_signon($info, true);


    if (is_wp_error($user_signon)) {

        wp_send_json_error([
            "message" => "Email or Password is wrong"
        ]);
    }

    wp_send_json_success(["message" => "Loging in ..."]);
}


add_action('wp_ajax_logout', 'logoutAjax');
function logoutAjax()
{
    wp_logout();

    wp_send_json_success([
        'message' => 'Loging out ...'
    ]);
}
