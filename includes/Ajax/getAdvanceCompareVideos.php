<?php

add_action('wp_ajax_advance-compare-videos', 'getAdvanceCompareVideos');

function getAdvanceCompareVideos()
{
    if (!isset($_POST['video_id'])) {
        $send_array =
            [
                'status' => 400,
                'message' => 'not gonna tell you!'
            ];
        wp_send_json_error($send_array);
    }

    $video_id = $_POST['video_id'];

    $foren = $_POST['foren'] ? $_POST['foren'] : 'false';

    $videos = [];
    if (have_rows('videos', $video_id)) {
        while (have_rows('videos', $video_id)) {
            the_row();
            // echo get_row_index();
            array_push($videos, [
                'id' => get_row_index(),
                'url' => get_sub_field('upload_or_url') ? get_sub_field('url') : get_sub_field('Upload'),
            ]);
        }
    }

    $main_video = get_field('main_video', $video_id);


    $advance_ids = $foren == 'true' ?  $_SESSION['advance_f_ids'] : $_SESSION['advance_ids'];

    $temp = 0;
    for ($i = 0; $i < count($advance_ids); $i++) {
        if ($advance_ids[$i] == $video_id) $temp = $i;
    }

    $next_video_id = false;
    if ($temp == count($advance_ids) - 1) $next_video_id = false;
    else $next_video_id =  $advance_ids[$temp + 1];

    if ($next_video_id == false) {
        update_field('finished_advance_compare_f_test', true, wp_get_current_user());
    }

    wp_send_json_success([
        'videos' => $videos,
        'main' => [
            'url' => $main_video['upload_or_url'] ? $main_video['url']  : $main_video['Upload']
        ],
        'next_url' => $next_video_id != false ?  str_replace(home_url(), '', get_the_permalink($next_video_id)) : get_the_permalink(get_page_by_path('thank-you')),
        'count' => count($advance_ids),
        'step' => $temp + 1,
    ]);
}


add_action('wp_ajax_advance-compare-save-answer', 'saveAdvanceVideoAnswer');

function saveAdvanceVideoAnswer()
{
    if (!isset($_POST['video_index']) or !isset($_POST['video_id']) or !isset($_REQUEST['screen_size']) or !isset($_REQUEST['foren']) or !isset($_REQUEST['browser'])) {
        $send_array =
            [
                'status' => 400,
                'message' => 'not gonna tell you!'
            ];
        wp_send_json_error($send_array);
    }

    write_log($_POST);


    $video_index = $_POST['video_index'];
    $video_id = $_POST['video_id'];
    $screen_size = $_POST['screen_size'];
    $foren = $_POST['foren'];
    $browser = $_POST['browser'];
    $location = getUserLocation();

    if (have_rows('videos', $video_id)) {
        while (have_rows('videos', $video_id)) {
            the_row();
            if (get_row_index() == $video_index) {
                $count = get_sub_field('answer_count');
                if (!$count) $count = 0;
                update_sub_field('answer_count', ++$count);

                $videoresult_id = wp_insert_post([
                    'post_author' => get_current_user_id(),
                    'post_type' => 'advance-result',
                    'status' => 'publish',
                ]);

                update_field('video', $video_id, $videoresult_id);
                update_field('screen_size', $screen_size, $videoresult_id);
                update_field('foren', $foren, $videoresult_id);
                update_field('browser', $browser, $videoresult_id);
                update_field('location', $location, $videoresult_id);
                $date = new DateTime('now');
                update_field('date',  $date->format('Y/m/d H:i:s'), $videoresult_id);
                update_field('device',  wp_is_mobile() ? 'Mobile' : 'PC', $videoresult_id);
                update_field('fps', get_sub_field('fps'), $videoresult_id);
                update_field('quality', get_sub_field('quality'), $videoresult_id);
                update_field('bitrate', get_sub_field('bitrate'), $videoresult_id);

                wp_send_json_success([
                    $count,
                    $screen_size,
                    $videoresult_id
                ]);
            }
        }
    }

    wp_send_json_error([]);
}



function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}

function getUserLocation()
{

    $PublicIP = get_client_ip();
    $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
    $json     = json_decode($json, true);
    $country  = $json['country'];
    $region   = $json['region'];
    $city     = $json['city'];

    return $country . ' - ' . $region . ' - ' . $city;
}
