let player = new Plyr('#player', {
    controls: [
        'play-large',
        'play',
        'current-time',
        'mute',
        'volume',
        'captions',
        'pip',
        'fullscreen',
    ],
    setting: [],
})

let seenVideo = false

$('.message').hide()

let quality = 0
let fps = 0
let bitrate = 0
let videos = []

$.get(
    {
        url: $('#infos').attr('data-url'),
        data: {
            action: 'get-video-info',
            video_id: $('#infos').attr('video-id'),
        },
    },
    function (jsonResponse) {
        console.log(jsonResponse.data)
        if (jsonResponse.success) {
            quality = jsonResponse.data.videos[0].size
            fps = jsonResponse.data.videos[0].fps
            bitrate = jsonResponse.data.videos[0].bitrate

            // console.log(quality)
            // console.log(fps)

            videos = jsonResponse.data.videos

            player.source = {
                type: 'video',
                title: jsonResponse.data.title,
                sources: [
                    {
                        src: jsonResponse.data.videos[0].src,
                        type: 'video/mp4',
                        size: 720,
                    },
                ],
                poster: jsonResponse.data.image,
            }
        } else {
            $('.message').slideDown(300)
            $('.message').addClass('alert-danger')
            $('.message').removeClass('alert-success')
            $('.message').text(jsonResponse.data.message)
        }
    }
)

$('#floatingSelect').on('change', function (e) {
    quality = $(this).find(':selected').attr('quality')
    fps = $(this).find(':selected').attr('fps')
    bitrate = $(this).find(':selected').attr('bitrate')

    // console.log(quality)
    // console.log(fps)

    const video = videos.find(
        (item) =>
            item.fps == fps && item.size == quality && item.bitrate == bitrate
    )

    player.source = {
        type: 'video',
        title: 'Example title',
        sources: [
            {
                src: video.src,
                type: 'video/mp4',
                size: 720,
            },
        ],
    }
})

let rate = 2
$('#customRange').on('change', function (e) {
    $('.rate').text(this.value)
    rate = this.value
})

$('.rate-video').on('click', (e) => {
    $('.rate-video').attr('disabled', true)

    const screen_size = $(window).width() + '*' + $(window).height()

    $.post(
        {
            url: $('#infos').attr('data-url'),
            data: {
                action: 'rate-video',
                video_id: $('#infos').attr('video-id'),
                rate,
                quality,
                fps,
                bitrate,
                screen_size,
            },
        },
        function (jsonResponse) {
            console.log(jsonResponse.data)

            if (jsonResponse.success) {
                if (!jsonResponse.data.finished) {
                    window.location.href = jsonResponse.data.next_video_url
                    return
                }
                window.location.href = '/rating-finished/'
            } else {
                $('.message').slideDown(300)
                $('.message').addClass('alert-danger')
                $('.message').removeClass('alert-success')
                $('.message').text(jsonResponse.data.message)
                $('.rate-video').attr('disabled', false)
            }
        }
    )
})

player.on('ended', (event) => {
    const instance = event.detail.plyr
    console.log('ended')
    $('.end-message').slideUp(100)
    $('.rate-video').slideDown(100)

    if (!seenVideo) $('.btn-replay').slideDown(100)
})

$('.btn-replay').on('click', (event) => {
    $('.btn-replay').slideUp(100)
    seenVideo = true
    player.currentTime = 0
    player.play()
    $('.end-message').slideDown(100)
    $('.rate-video').slideUp(100)
})
