<?php

if (get_field('last_compare_video_reviewed', wp_get_current_user()) >= get_the_ID() and !get_field('custom_or_fixed')) {

    $compareVideos = get_posts([
        'post_type' => 'compare-video',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'order' => 'ASC',
    ]);

    $next_video_id = 0;
    if (get_field('last_compare_video_reviewed', wp_get_current_user())) {
        $index = -1;
        for ($i = 0; $i < count($compareVideos); $i++) {
            if (
                $compareVideos[$i] == get_field('last_compare_video_reviewed', wp_get_current_user())
                and ($i + 1) < count($compareVideos)
            ) {
                $index = $i + 1;
                break;
            }
        }

        if ($index and $index != -1) {
            $next_video_id = $compareVideos[$index];
        }
    }

    if (get_field('finished_compare_test', wp_get_current_user()) and !$next_video_id)
        wp_die('You already finished this test <a href="' . get_site_url() . '">Go Home</a>');


    wp_die('You already rate for this video <a href="' . get_the_permalink($next_video_id) . '">Go to Next Video</a>');
}
?>

<div class="container">
    <div class="mt-5">


        <div class="alert mb-3 message"></div>


        <div class=" row">

            <div class="col-md-6">
                <h3 class="text-center">Video 1</h3>
                <video id="player1"></video>
            </div>

            <div class="col-md-6 mt-3 mt-md-0">
                <h3 class="text-center">Video 2</h3>
                <video id="player2"></video>
            </div>

        </div>



        <div class="text-center mt-3">
            <button class="btn btn-info btn-replay text-white" style="display: none;">
                <h4 class="m-0 p-2">
                    Replay
                </h4>
            </button>
        </div>


        <div class="mt-3 rate-video" style="display: none;">
            <div class="alert alert-info">
                Same Video?
            </div>
            <class class="row">
                <div class="col">
                    <button class="btn btn-danger w-100" value="false">No</button>
                </div>
                <div class="col">
                    <button class="btn btn-success w-100" value="true">Yes</button>
                </div>
            </class>
            <alert class="alert alert-warning end-message">Please watch video to the end for rating!</alert>
        </div>

    </div>
</div>

<div id="infos" video-id=<?php the_ID() ?> data-url="<?php echo admin_url('admin-ajax.php') ?>"></div>



<script>

</script>