<?php

if (get_field('last_video_reviewed', wp_get_current_user()) >= get_the_ID() and !get_field('custom_or_fixed')) {

    $fixedVideos = get_posts([
        'post_type' => 'video',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'order' => 'ASC',
        'meta_key'        => 'custom_or_fixed',
        'meta_value'    => '0'
    ]);

    $next_video_id = 0;
    if (get_field('last_video_reviewed', wp_get_current_user())) {
        $index = -1;
        for ($i = 0; $i < count($fixedVideos); $i++) {
            if (
                $fixedVideos[$i] == get_field('last_video_reviewed', wp_get_current_user())
                and ($i + 1) < count($fixedVideos)
            ) {
                $index = $i + 1;
                break;
            }
        }

        if ($index and $index != -1) {
            $next_video_id = $fixedVideos[$index];
        }
    }

    if (get_field('finished_fixed_test', wp_get_current_user()) and !$next_video_id)
        wp_die('You already finished this test <a href="' . get_site_url() . '">Go Home</a>');


    wp_die('You already rate for this video <a href="' . get_the_permalink($next_video_id) . '">Go to Next Video</a>');
}

$qualities = [];
$str = 'videos';
if (!get_field('custom_or_fixed')) {
    $str = 'videos_fixed';
}

if (have_rows($str)) :
    while (have_rows($str)) {
        the_row();

        array_push($qualities, [
            'quality' => get_sub_field('quality'),
            'fps' => get_sub_field('fps'),
            'bitrate' => get_sub_field('bitrate') ? get_sub_field('bitrate') : 0,
        ]);
    } else :
endif;

?>

<div class="container">
    <div class="mt-5">


        <div class="alert mb-3 message"></div>

        <div class="row">

            <div class="col-md-9">

                <div class="">
                    <video id="player"></video>
                </div>

            </div>


            <div class="col-md">

                <div class="form-floating mt-3 <?php if (!get_field('custom_or_fixed')) echo 'd-none' ?>">

                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                        <?php for ($i = 0; $i < count($qualities); $i++) : ?>
                            <option quality="<?php echo $qualities[$i]['quality'] ?>" fps="<?php echo $qualities[$i]['fps'] ?>" bitrate="<?php echo $qualities[$i]['bitrate'] ?>" <?php echo $i == 0 ? 'selected' : null ?>>
                                <?php echo $qualities[$i]['quality'] . "p " . $qualities[$i]['fps'] . "fps " . $qualities[$i]['bitrate'] . "bitrate"   ?>
                            </option>
                        <?php endfor ?>
                    </select>

                    <label for="floatingSelect">Choose Quality and Frame Rate</label>

                </div>


                <label for="customRange" class="form-label mt-3">Rate</label>
                <div class="d-flex justify-content-center align-items-center">
                    <input type="range" class="form-range" value="2" min="1" max="5" step="1" id="customRange">
                    <h3 class="rate ms-3">2</h3>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button class="btn btn-lg btn-success btn-block rate-video" style="display: none;">
                        <h3>
                            Save My Rate
                        </h3>
                    </button>

                    <button class="btn btn-primary btn-replay text-white" style="display: none;">
                        <h4>
                            Replay
                        </h4>
                    </button>
                </div>

            </div>

        </div>


        <div class="d-grid gap-2 mt-3">
            <alert class="alert alert-warning end-message">Please watch video to the end for rating!</alert>
        </div>

    </div>
</div>

<div id="infos" video-id=<?php the_ID() ?> data-url="<?php echo admin_url('admin-ajax.php') ?>"></div>



<script>

</script>