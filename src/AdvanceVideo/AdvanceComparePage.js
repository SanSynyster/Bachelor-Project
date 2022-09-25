import React, { useState, useEffect, useRef } from 'react'
import Plyr from 'plyr-react'
import ReactPlayer from 'react-player'

import 'plyr-react/dist/plyr.css'

import Button from './Button'
import Video from './Video'

$ = jQuery

function calculateMid(min, max) {
    const mid = Math.floor((max - min) / 2 + min)

    return mid
}

const browserName = () => {
    const agent = window.navigator.userAgent.toLowerCase()
    switch (true) {
        case agent.indexOf('edge') > -1:
            return 'MS Edge'
        case agent.indexOf('edg/') > -1:
            return 'Edge ( chromium based)'
        case agent.indexOf('opr') > -1 && !!window.opr:
            return 'Opera'
        case agent.indexOf('chrome') > -1 && !!window.chrome:
            return 'Chrome'
        case agent.indexOf('trident') > -1:
            return 'MS IE'
        case agent.indexOf('firefox') > -1:
            return 'Mozilla Firefox'
        case agent.indexOf('safari') > -1:
            return 'Safari'
        default:
            return 'other'
    }
}

function AdvanceComparePage() {
    const [videos, setVideos] = useState([])
    const [mainVideo, setMainVideo] = useState()
    const [showMainVideo, setShowMainVideo] = useState(true)
    const [showButtons, setShowButtons] = useState(false)
    const [showLoading, setShowLoading] = useState(true)
    const [isPlaying, setIsPlaying] = useState(false)
    const [min, setMin] = useState(0)
    const [max, setMax] = useState(0)
    const [mid, setMid] = useState(0)
    const [nextUrl, setNextUrl] = useState('')
    const [finished, setFinished] = useState(false)

    const DevMode = window.location.href.includes('local')

    const playMainRef = useRef()
    const playTestRef = useRef()

    const [hasReplayed, setHasReplayed] = useState(false)

    const [step, setStep] = useState(0)
    const [count, setCount] = useState(0)

    useEffect(() => {
        DevMode && console.log(browserName())
        $.post(
            {
                url: $('#ajax_url').attr('ajax_url'),
                data: {
                    action: 'advance-compare-videos',
                    video_id: $('#video_id').attr('video_id'),
                    foren: $('#video_id').attr('foren'),
                },
            },
            function (res) {
                DevMode && console.log('RESPONSE:')
                DevMode && console.log(res)
                setVideos(res.data.videos)
                setMainVideo(res.data.main)
                setMin(1)
                setMax(res.data.videos.length)
                setMid(calculateMid(1, res.data.videos.length))
                setNextUrl(res.data.next_url)
                setStep(res.data.step)
                setCount(res.data.count)
            }
        )
    }, [])

    DevMode && console.log('min: ' + min)
    DevMode && console.log('max: ' + max)
    DevMode && console.log('mid: ' + mid)

    function onClickYesHandel(event) {
        event.preventDefault()
        setMin(mid)
        const newMid = calculateMid(mid, max)
        setMid(newMid)
        if (max - mid === 1) {
            setFinished(true)
            DevMode && console.log('****DONE****')
            DevMode && console.log('ANSWER: ' + max)
            sendAnswer(max)
        }
        setShowMainVideo(true)
        setShowButtons(false)
        setHasReplayed(false)
    }

    function onClickNoHandel(event) {
        event.preventDefault()
        setMax(mid)
        const newMid = calculateMid(min, mid)
        setMid(newMid)
        if (mid - min === 1) {
            setFinished(true)
            DevMode && console.log('****DONE****')
            DevMode && console.log('ANSWER: ' + mid)
            sendAnswer(mid)
        }
        setShowMainVideo(true)
        setShowButtons(false)
        setHasReplayed(false)
    }

    function sendAnswer(video_index) {
        const screen_size = $(window).width() + '*' + $(window).height()

        $.post(
            {
                url: $('#ajax_url').attr('ajax_url'),
                data: {
                    action: 'advance-compare-save-answer',
                    video_index,
                    video_id: $('#video_id').attr('video_id'),
                    screen_size,
                    foren: $('#video_id').attr('foren'),
                    browser: browserName(),
                },
            },
            function (res) {
                window.location.href = nextUrl
                DevMode && console.log(res)
            }
        )
    }

    function togglePlay() {
        setIsPlaying((pre) => !pre)
    }

    return (
        <div
            className=''
            style={{
                backgroundColor: '#444',
                color: 'white',
            }}
        >
            <div
                className='container- py-3 px-2 d-flex justify-content-center align-items-center'
                style={{
                    height: '100vh',
                    maxWidth: '95%',
                }}
            >
                <div className='responsive-div- h-100 w-100'>
                    {finished ? (
                        <div className='alert alert-warning'>Loading...</div>
                    ) : (
                        <>
                            <div className='row h-100'>
                                <div className='col-12 col-md-10'>
                                    {showMainVideo ? (
                                        mainVideo && (
                                            <>
                                                <ReactPlayer
                                                    url={mainVideo['url']}
                                                    playing={isPlaying}
                                                    onEnded={() => {
                                                        setShowMainVideo(false)
                                                        setShowLoading(true)
                                                        setIsPlaying(false)
                                                        setTimeout(
                                                            function () {
                                                                setShowLoading(
                                                                    false
                                                                )
                                                            },
                                                            DevMode
                                                                ? 4000
                                                                : 4000
                                                        )
                                                    }}
                                                    width='100%'
                                                    height='inherit'
                                                    ref={playMainRef}
                                                    controls={DevMode}
                                                />
                                            </>
                                        )
                                    ) : showLoading ? (
                                        <>
                                            <h2>Loading test video</h2>
                                            <div
                                                class='spinner-border'
                                                role='status'
                                            >
                                                <span class='visually-hidden'>
                                                    Loading...
                                                </span>
                                            </div>
                                        </>
                                    ) : (
                                        videos.length &&
                                        min * max && (
                                            <>
                                                <ReactPlayer
                                                    url={videos[mid]['url']}
                                                    playing={isPlaying}
                                                    onEnded={() => {
                                                        setIsPlaying(false)
                                                        setShowButtons(true)
                                                    }}
                                                    width='100%'
                                                    height='inherit'
                                                    ref={playTestRef}
                                                    controls={DevMode}
                                                />
                                            </>
                                        )
                                    )}
                                </div>

                                <div className='col-12 col-md-2 mt-3'>
                                    <h2>
                                        Step {step}/{count}
                                    </h2>
                                    <h2
                                        style={{
                                            fontSize: '1.5rem',
                                            fontWeight: 300,
                                            marginBottom: 40,
                                        }}
                                    >
                                        {showMainVideo
                                            ? 'Original Video'
                                            : 'Test Video'}
                                    </h2>
                                    <div className=''>
                                        <div className='mt-auto justify-content-center align-items-center'>
                                            {showButtons ? (
                                                <div className='compare-buttons text-center my-md-5'>
                                                    <h4 className='text-center'>
                                                        Can you see any
                                                        difference?
                                                    </h4>
                                                    <div className='d-flex flex-column'>
                                                        <Button
                                                            onClick={
                                                                onClickYesHandel
                                                            }
                                                            className='mb-2 btn-success'
                                                        >
                                                            Yes
                                                        </Button>
                                                        <Button
                                                            onClick={
                                                                onClickNoHandel
                                                            }
                                                            className='btn-danger'
                                                        >
                                                            No
                                                        </Button>
                                                    </div>
                                                </div>
                                            ) : (
                                                <h4 className='text-center my-md-5'>
                                                    For rating, wait for the
                                                    video to finish
                                                </h4>
                                            )}
                                            <div className='mt-3 d-flex flex-column text-center'>
                                                <h3>Controls</h3>
                                                <div className='d-flex flex-column'>
                                                    <Button
                                                        className='mb-2'
                                                        onClick={togglePlay}
                                                    >
                                                        {isPlaying
                                                            ? ' Pause'
                                                            : 'Play'}
                                                    </Button>
                                                    <Button
                                                        className=''
                                                        onClick={() => {
                                                            if (!hasReplayed) {
                                                                if (
                                                                    playMainRef.current &&
                                                                    playMainRef
                                                                        .current
                                                                        .seekTo
                                                                ) {
                                                                    playMainRef.current.seekTo(
                                                                        0
                                                                    )
                                                                }
                                                                if (
                                                                    playTestRef.current &&
                                                                    playTestRef
                                                                        .current
                                                                        .seekTo
                                                                ) {
                                                                    playTestRef.current.seekTo(
                                                                        0
                                                                    )
                                                                }

                                                                setShowMainVideo(
                                                                    true
                                                                )
                                                                setShowButtons(
                                                                    false
                                                                )
                                                                setHasReplayed(
                                                                    true
                                                                )
                                                            }
                                                        }}
                                                        disabled={hasReplayed}
                                                    >
                                                        Replay
                                                    </Button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </>
                    )}
                </div>
            </div>
        </div>
    )
}

export default AdvanceComparePage
