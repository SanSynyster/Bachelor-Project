import React, { useState, useEffect, useSear } from 'react'
import VideoTable from './VideoTable'

function VideoResults() {
    const [results, setResults] = useState([])

    useEffect(() => {
        const urlParams = new URLSearchParams(window.location.search)
        const video_id = urlParams.get('video_id')
        if (video_id)
            $.post(
                {
                    url: $('#ajax_url').attr('ajax_url'),
                    data: {
                        action: 'advance-video-result',
                        video_id,
                    },
                },
                function (res) {
                    console.log(res)
                    setResults(res.data.results)
                }
            )
    }, [])

    return (
        <div>
            here
            {results && results.length > 0 && <VideoTable data={results} />}
        </div>
    )
}

export default VideoResults
