let player1 = new Plyr("#player1", {
    controls: [
        "play-large",
        "play",
        "current-time",
        "mute",
        "volume",
        "captions",
        "pip",
        "fullscreen",
    ],
    setting: [],
});

let player2 = new Plyr("#player2", {
    controls: [
        "play-large",
        "play",
        "current-time",
        "mute",
        "volume",
        "captions",
        "pip",
        "fullscreen",
    ],
    setting: [],
});

let seenVideo = false;

$(".message").hide();

$.get(
    {
        url: $("#infos").attr("data-url"),
        data: {
            action: "get-compare-video-info",
            video_id: $("#infos").attr("video-id"),
        },
    },
    function (jsonResponse) {
        console.log(jsonResponse.data);
        if (jsonResponse.success) {
            player1.source = {
                type: "video",
                title: jsonResponse.data.title,
                sources: [
                    {
                        src: jsonResponse.data.video1,
                        type: "video/mp4",
                        size: 720,
                    },
                ],
                poster: jsonResponse.data.image ? jsonResponse.data.image : "",
            };

            player2.source = {
                type: "video",
                title: jsonResponse.data.title,
                sources: [
                    {
                        src: jsonResponse.data.video2,
                        type: "video/mp4",
                        size: 720,
                    },
                ],
                poster: jsonResponse.data.image ? jsonResponse.data.image : "",
            };
        } else {
            $(".message").slideDown(300);
            $(".message").addClass("alert-danger");
            $(".message").removeClass("alert-success");
            $(".message").text(jsonResponse.data.message);
        }
    }
);

player1.on("play", (event) => playVideo(event));

player2.on("play", (event) => playVideo(event));

function playVideo(event) {
    player1.play();
    player2.play();
}

player1.on("pause", (event) => pauseVideo(event));

player2.on("pause", (event) => pauseVideo(event));

function pauseVideo(event) {
    player1.pause();
    player2.pause();
}

player1.on("ended", (event) => endPlaying(event));
player2.on("ended", (event) => endPlaying(event));

function endPlaying(event) {
    $(".end-message").slideUp(100);
    $(".rate-video").slideDown(100);

    if (!seenVideo) $(".btn-replay").slideDown(100);
}

function helper() {
    player1.currentTime = 99999999;
    player2.currentTime = 99999999;
}

$(".btn-replay").on("click", (event) => {
    $(".btn-replay").slideUp(100);
    seenVideo = true;
    player1.currentTime = 0;
    player2.currentTime = 0;
    player1.play();
    player2.play();
    $(".end-message").slideDown(100);
    $(".rate-video").slideUp(100);
});

$(".rate-video button").on("click", (event) => {
    console.log($(event.target).val());

    $(".rate-video").attr("disabled", true);
    $(".rate-video button").attr("disabled", true);

    const screen_size = $(window).width() + "*" + $(window).height();

    $.post(
        {
            url: $("#infos").attr("data-url"),
            data: {
                action: "rate-compare-video",
                video_id: $("#infos").attr("video-id"),
                value: $(event.target).val(),
                screen_size,
            },
        },
        function (jsonResponse) {
            console.log(jsonResponse.data);

            if (jsonResponse.success) {
                // return;
                if (!jsonResponse.data.finished) {
                    window.location.href = jsonResponse.data.next_video_url;
                    return;
                }
                window.location.href = "/rating-finished/";
            } else {
                $(".message").slideDown(300);
                $(".message").addClass("alert-danger");
                $(".message").removeClass("alert-success");
                $(".message").text(jsonResponse.data.message);
                $(".rate-video").attr("disabled", false);
                $(".rate-video button").attr("disabled", false);
            }
        }
    );
});
