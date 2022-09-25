<?php

add_action('wp_ajax_advance-video-result', 'getAdvanceVideoResultAjax');

function getAdvanceVideoResultAjax()
{
    if (!isset($_POST['video_id'])) {
        wp_send_json_error(['error' => 'video id is needed']);
    }

    $video_id  = $_POST['video_id'];

    wp_send_json_success([
        'results' => getAdvanceVideoResultArr($video_id),
        $video_id
    ]);
}

add_action('wp_ajax_advance-video-result-csv', 'getAdvanceVideoResultCsv');

function getAdvanceVideoResultCsv()
{
    if (!isset($_POST['video_id'])) {
        wp_send_json_error(['error' => 'video id is needed']);
    }

    $video_id  = $_POST['video_id'];

    $array = getAdvanceVideoResultArr($video_id);

    $path = wp_upload_dir();
    $out = fopen($path['path'] . '/' . get_the_title($video_id) . '_results.xls', "w");

    fputcsv($out, array_keys($array[0]), "\t");

    foreach ($array as $data) {
        fputcsv($out, $data, "\t");
    }

    fclose($out);

    wp_send_json_success([
        "url" => $path['url'] . '/' . get_the_title($video_id) . '_results.xls',
    ]);
}

function getAdvanceVideoResultArr($video_id)
{

    $videos = [];
    if (have_rows('videos', $video_id)) {
        while (have_rows('videos', $video_id)) {
            the_row();
            array_push($videos, [
                'quality' => get_sub_field('quality'),
                'fps' => get_sub_field('fps'),
                'bitrate' => get_sub_field('bitrate'),
                'answer_count' => get_sub_field('answer_count') ? intval(get_sub_field('answer_count')) : 0,
            ]);
        }
    }

    return $videos;

    //     $results = new WP_Query([
    //         'post_type' => 'advance-result',
    //         'posts_per_page' => -1,
    //     ]);

    //     $send_arr = [];

    //     while ($results->have_posts()) {
    //         $results->the_post();

    //         $video_id = get_field('video');
    //         if ($video_id and get_post_status($video_id) == 'publish') {
    //             $user = get_user_by('ID', get_the_author_ID());
    //             $age = get_field('age', $user);
    //             $gender = get_field('gender', $user);

    //             $quality = get_field('quality');
    //             $fps = get_field('fps');
    //             $device = get_field('device');
    //             // $rate = get_field('rate');
    //             $screen_size = get_field('screen_size');
    //             $date = get_field('date');
    //             $bitrate = get_field('bitrate');
    //             // $custom = get_field('custom_or_fixed', $video_id) ? 'Yes' : 'No';

    //             array_push($send_arr, [
    //                 'video' => get_the_title($video_id),
    //                 'quality' => $quality,
    //                 'user' => getUserFullName(get_the_author_ID()),
    //                 'email' => $user->data->user_email,
    //                 'screen_size' => $screen_size,
    //                 'date' => $date,
    //                 'age' => $age,
    //                 'gender' => $gender,
    //                 'fps' => $fps,
    //                 'device' => $device,
    //                 'bitrate' => $bitrate,
    //                 'id' => $video_id,
    //             ]);
    //         }
    //     }

    //     return $send_arr;
}
