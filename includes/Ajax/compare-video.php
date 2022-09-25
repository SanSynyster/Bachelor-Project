<?php

add_action('wp_ajax_get-compare-video-info', 'getCompareVideoInfo');

function getCompareVideoInfo()
{
    if (!isset($_REQUEST['video_id'])) {
        wp_send_json_error([
            "message" => "Data didn't load correctly. Please refresh the page and try again",
            $_REQUEST
        ]);
    }

    $video_id = $_REQUEST['video_id'];

    if (get_post_type($video_id) != 'compare-video') {
        wp_send_json_error([
            "message" => "Data didn't load correctly. Please refresh the page and try again"
        ]);
    }


    wp_send_json_success(
        [
            "message" => "SUCCESS!",
            'title' => get_the_title($video_id),
            'image' =>  get_the_post_thumbnail_url($video_id),
            'video1' => get_field('video_number_1', $video_id),
            'video2' => get_field('video_number_2', $video_id),
        ]
    );
}


add_action('wp_ajax_rate-compare-video', 'rateCompareVideo');

function rateCompareVideo()
{
    if (!isset($_REQUEST['video_id'])  or !isset($_REQUEST['value']) or !isset($_REQUEST['screen_size'])) {
        wp_send_json_error([
            "message" => "Data didn't load correctly. Please refresh the page and try again"
        ]);
    }

    $video_id = $_REQUEST['video_id'];

    if (get_post_type($video_id) != 'compare-video') {
        wp_send_json_error([
            "message" => "Data didn't load correctly. Please refresh the page and try again"
        ]);
    }

    $value = $_REQUEST['value'];

    $screen_size =  $_REQUEST['screen_size'];

    $user_id = get_current_user_id();

    $videoresult_id = wp_insert_post([
        'post_author' => $user_id,
        'post_type' => 'compare-video-result',
        'status' => 'publish',
    ]);
    if ($videoresult_id <= 0) {
        wp_send_json_error([
            "message" => "Data didn't load correctly. Please refresh the page and try again"
        ]);
    }

    update_field('video', $video_id, $videoresult_id);
    update_field('value', $value == "true" ? true : false, $videoresult_id);
    update_field('screen_size', $screen_size, $videoresult_id);
    update_field('device', wp_is_mobile() ? 'Mobile' : 'PC', $videoresult_id);
    update_field('last_compare_video_reviewed', $video_id, wp_get_current_user());

    $date = new DateTime('now');
    // $date = $date->format('Ymd');

    update_field('date', $date->format('Y/m/d H:i:s'), $videoresult_id);

    // $all_videos = get_posts([
    //     'post_type' => 'compare-video',
    //     'posts_per_page' => -1,
    //     'fields' => 'ids',
    //     'order' => 'ASC',
    // ]);

    // $index = -1;
    // for ($i = 0; $i < count($all_videos); $i++) {
    //     if (
    //         $all_videos[$i] == $video_id
    //         and ($i + 1) < count($all_videos)
    //     ) {
    //         $index = $i + 1;
    //         break;
    //     }
    // }

    $next_video_id =  getNextPost($video_id);

    if ($next_video_id) {
        wp_send_json_success([
            'next_video_url' => str_replace(home_url(), '', get_the_permalink($next_video_id)),
            'finished' => false,
        ]);
    }

    update_field('finished_compare_test', true, wp_get_current_user());

    wp_send_json_success([
        'finished' => true,
    ]);
}

function getNextPost($post_id)
{
    $all_videos = get_posts([
        'post_type' => get_post_type($post_id),
        'posts_per_page' => -1,
        'fields' => 'ids',
        'order' => 'ASC',
    ]);

    $index = -1;
    for ($i = 0; $i < count($all_videos); $i++) {
        if (
            $all_videos[$i] == $post_id
            and ($i + 1) < count($all_videos)
        ) {
            $index = $i + 1;
            break;
        }
    }

    if ($index == -1) return false;

    return  $all_videos[$index];
}


// 
// 
// 

add_action('wp_ajax_get-compare-results', 'getCompareResults');

function getCompareResults()
{
    wp_send_json_success(getCompareResultsArr());
}

add_action('wp_ajax_get-compare-results-csv', 'getCompareResultsCsv');

function getCompareResultsCsv()
{
    $array = getCompareResultsArr();

    $path = wp_upload_dir();
    $out = fopen($path['path'] . "/compareResults.xls", "w");

    fputcsv($out, array_keys($array[0]), "\t");

    foreach ($array as $data) {
        fputcsv($out, $data, "\t");
    }

    fclose($out);

    wp_send_json_success([
        "url" => $path['url'] . '/compareResults.xls',
    ]);
}

function getCompareResultsArr()
{
    $results = new WP_Query([
        'post_type' => 'compare-video-result',
        'posts_per_page' => -1,
    ]);

    $send_arr = [];

    while ($results->have_posts()) {
        $results->the_post();

        $video_id = get_field('video');
        if ($video_id and get_post_status($video_id) == 'publish') {
            $user = get_user_by('ID', get_the_author_ID());
            $age = get_field('age', $user);
            $gender = get_field('gender', $user);
            $connection_type = get_field('connection_type', $user);

            $device = get_field('device');
            $value = get_field('value') ? "1" : "0";
            $screen_size = get_field('screen_size');
            $date = get_field('date');

            array_push($send_arr, [
                'video' => get_the_title($video_id),
                'user' => getUserFullName(get_the_author_ID()),
                'email' => $user->data->user_email,
                'value' => $value,
                'screen_size' => $screen_size,
                'date' => $date,
                'age' => $age,
                'gender' => $gender,
                'device' => $device,
                'connection_type' => $connection_type,
            ]);
        }
    }

    return $send_arr;
}
