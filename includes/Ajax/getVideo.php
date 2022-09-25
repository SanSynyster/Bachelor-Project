<?php

add_action('wp_ajax_get-video-info', 'getVideoInfo');

function getVideoInfo()
{
    if (!isset($_REQUEST['video_id'])) {
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

    $videos = [];
    $str = 'videos';
    if (!get_field('custom_or_fixed', $video_id)) {
        $str = 'videos_fixed';
    }
    if (have_rows($str, $video_id)) :

        while (have_rows($str, $video_id)) {
            the_row();

            if (get_sub_field('upload_or_url'))
                array_push($videos, [
                    'size' => get_sub_field('quality'),
                    'fps' => get_sub_field('fps'),
                    'bitrate' => get_sub_field('bitrate') ? get_sub_field('bitrate') : 0,
                    'src' => get_sub_field('url'),
                ]);
            else
                array_push($videos, [
                    'size' => get_sub_field('quality'),
                    'fps' => get_sub_field('fps'),
                    'bitrate' => get_sub_field('bitrate') ? get_sub_field('bitrate') : 0,
                    'src' => get_sub_field('Upload'),
                ]);
        } else :
    endif;


    wp_send_json_success(
        [
            "message" => "SUCCESS!",
            'title' => get_the_title($video_id),
            'image' => get_the_post_thumbnail_url($video_id),
            'videos' => $videos,
        ]
    );
}
