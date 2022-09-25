<?php

add_action('wp_ajax_rate-video', 'rateVideo');

function rateVideo()
{
    if (!isset($_REQUEST['video_id']) or !isset($_REQUEST['rate']) or !isset($_REQUEST['quality']) or !isset($_REQUEST['screen_size']) or !isset($_REQUEST['fps']) or !isset($_REQUEST['bitrate'])) {
        wp_send_json_error([
            "message" => "Data didn't load correctly. Please refresh the page and try again"
        ]);
    }

    $video_id = $_REQUEST['video_id'];

    if (get_post_type($video_id) != 'video') {
        wp_send_json_error([
            "message" => "Data didn't load correctly. Please refresh the page and try again"
        ]);
    }

    $rate = $_REQUEST['rate'];

    if (!is_numeric($rate) or $rate > 5 or $rate < 1) {
        wp_send_json_error([
            "message" => "Rate can be only between 1 and 5"
        ]);
    }

    $quality = $_REQUEST['quality'];
    $screen_size =  $_REQUEST['screen_size'];
    $fps =  $_REQUEST['fps'];
    $bitrate =  $_REQUEST['bitrate'];

    $user_id = get_current_user_id();

    $videoresult_id = wp_insert_post([
        'post_author' => $user_id,
        'post_type' => 'videoresult',
        'status' => 'publish',
    ]);
    if (!($videoresult_id > 0)) {
        wp_send_json_error([
            "message" => "Data didn't load correctly. Please refresh the page and try again"
        ]);
    }

    update_field('video', $video_id, $videoresult_id);
    update_field('rate', $rate, $videoresult_id);
    update_field('quality', $quality, $videoresult_id);
    update_field('screen_size', $screen_size, $videoresult_id);
    update_field('fps', $fps, $videoresult_id);
    update_field('bitrate', $bitrate, $videoresult_id);
    update_field('device', wp_is_mobile() ? 'Mobile' : 'PC', $videoresult_id);
    update_field('last_video_reviewed', $video_id, wp_get_current_user());

    $date = new DateTime('now');
    // $date = $date->format('Ymd');

    update_field('date', $date->format('Y/m/d H:i:s'), $videoresult_id);

    $all_videos = get_posts([
        'post_type' => 'video',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'order' => 'ASC',
        'meta_key'        => 'custom_or_fixed',
        'meta_value'    => get_field('custom_or_fixed', $video_id) ? '1' : '0',
    ]);

    $index = -1;
    for ($i = 0; $i < count($all_videos); $i++) {
        if (
            $all_videos[$i] == $video_id
            and ($i + 1) < count($all_videos)
        ) {
            $index = $i + 1;
            break;
        }
    }

    if ($index != -1) {
        $next_video_id = $all_videos[$index];

        wp_send_json_success([
            'next_video_url' => str_replace(home_url(), '', get_the_permalink($next_video_id)),
            'finished' => false,
        ]);
    }

    if (!get_field('custom_or_fixed', $video_id))
        update_field('finished_fixed_test', true, wp_get_current_user());

    wp_send_json_success([
        'finished' => true,
    ]);
}

add_action('wp_ajax_get-results', 'getResults');

function getResults()
{
    wp_send_json_success(getResultsArr());
}

add_action('wp_ajax_get-results-csv', 'getResultsCsv');

function getResultsCsv()
{
    $array = getResultsArr();

    $path = wp_upload_dir();
    $out = fopen($path['path'] . "/shippinglabels.xls", "w");

    fputcsv($out, array_keys($array[0]), "\t");

    foreach ($array as $data) {
        fputcsv($out, $data, "\t");
    }

    fclose($out);

    wp_send_json_success([
        "url" => $path['url'] . '/shippinglabels.xls',
    ]);
}

function getResultsArr()
{
    $results = new WP_Query([
        'post_type' => 'videoresult',
        // 'order'     => '',
        'posts_per_page' => -1,
        // 'post_per_page' => -1
        // 'order' => 'ASC',
    ]);

    $send_arr = [];

    while ($results->have_posts()) {
        $results->the_post();

        $video_id = get_field('video');
        if ($video_id and get_post_status($video_id) == 'publish') {
            $user = get_user_by('ID', get_the_author_ID());
            $age = get_field('age', $user);
            $gender = get_field('gender', $user);

            $quality = get_field('quality');
            $fps = get_field('fps');
            $bitrate = get_field('bitrate');
            $device = get_field('device');
            $rate = get_field('rate');
            $screen_size = get_field('screen_size');
            $date = get_field('date');
            $custom = get_field('custom_or_fixed', $video_id) ? 'Yes' : 'No';

            array_push($send_arr, [
                'video' => get_the_title($video_id),
                'quality' => $quality,
                'user' => getUserFullName(get_the_author_ID()),
                'email' => $user->data->user_email,
                'rate' => $rate,
                'screen_size' => $screen_size,
                'date' => $date,
                'custom' => $custom,
                'age' => $age,
                'gender' => $gender,
                'fps' => $fps,
                'bitrate' => $bitrate,
                'device' => $device,
            ]);
        }
    }

    return $send_arr;
}
