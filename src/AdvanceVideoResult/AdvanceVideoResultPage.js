import React, { useState, useEffect } from 'react'
import VideoResults from './VideoResults'

function AdvanceVideoResultPage() {
    const [downloadLink, setDownloadLink] = useState()
    useEffect(() => {
        const urlParams = new URLSearchParams(window.location.search)
        const video_id = urlParams.get('video_id')
        if (video_id)
            $.post(
                {
                    url: $('#ajax_url').attr('ajax_url'),
                    data: {
                        action: 'advance-video-result-csv',
                        video_id,
                    },
                },
                function (res) {
                    console.log(res)
                    setDownloadLink(res.data.url)
                }
            )
    }, [])

    return (
        <div className='container'>
            <VideoResults />
            {downloadLink && (
                <a
                    href={downloadLink}
                    class='btn btn-success download-excel mt-2'
                >
                    Download Results
                </a>
            )}
        </div>
    )
}

export default AdvanceVideoResultPage
