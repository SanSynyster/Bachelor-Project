<?php

add_action('wp_ajax_advance-compare-results', 'getAdvanceResultsAjax');

function getAdvanceResultsAjax()
{
    wp_send_json_success([
        'results' => getAdvanceResultsArr(),
    ]);
}

add_action('wp_ajax_advance-compare-results-csv', 'getAdvanceResultsCsv');

function getAdvanceResultsCsv()
{
    $array = getAdvanceResultsArr();

    $path = wp_upload_dir();
    $out = fopen($path['path'] . "/advanceResults.xls", "w");

    fputcsv($out, array_keys($array[0]), "\t");

    foreach ($array as $data) {
        fputcsv($out, $data, "\t");
    }

    fclose($out);

    wp_send_json_success([
        "url" => $path['url'] . '/advanceResults.xls',
    ]);
}

function getAdvanceResultsArr()
{
    $results_arr = [
        'post_type' => 'advance-result',
        'posts_per_page' => -1,

    ];

    if (isset($_POST['foren']) and $_POST['foren'] == 'true') {
        $results_arr['meta_query']    = [
            'relation'        => 'AND',
            [
                'key'         => 'foren',
                'value'          => 'true',
                'compare'     => '==',
            ],
        ];
    } else {
        $results_arr['meta_query']    = [
            'relation'        => 'OR',
            [
                'key'         => 'foren',
                'value'          => 'false',
                'compare'     => '==',
            ],
            [
                'key'         => 'foren',
                'compare'     => 'NOT EXISTS',
            ],
        ];
    }

    $results = new WP_Query($results_arr);

    $send_arr = [];

    while ($results->have_posts()) {
        $results->the_post();

        $video_id = get_field('video');
        if ($video_id and get_post_status($video_id) == 'publish') {
            $user = get_user_by('ID', get_the_author_ID());
            $age = get_field('age', $user);
            $gender = get_field('gender', $user);
            $connection_type = get_field('connection_type', $user);

            $quality = get_field('quality');
            $fps = get_field('fps');
            $device = get_field('device');
            // $rate = get_field('rate');
            $screen_size = get_field('screen_size');
            $date = get_field('date');
            $bitrate = get_field('bitrate');
            $foren = get_field('foren');
            $browser = get_field('browser');
            $location = get_field('location');
            // $custom = get_field('custom_or_fixed', $video_id) ? 'Yes' : 'No';

            array_push($send_arr, [
                'video' => get_the_title($video_id),
                'quality' => $quality,
                'user_id' => get_the_author_ID(),
                'user' => getUserFullName(get_the_author_ID()),
                'email' => $user->data->user_email,
                'screen_size' => $screen_size,
                'date' => $date,
                'age' => $age,
                'gender' => $gender,
                'fps' => $fps,
                'device' => $device,
                'bitrate' => $bitrate,
                'id' => $video_id,
                'foren' => $foren ? $foren : 'false',
                'browser' =>  $browser,
                'location' => $location,
                'connection_type' => $connection_type,
            ]);
        }
    }

    return $send_arr;
}
