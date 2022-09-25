import React, { useEffect, useState } from 'react'
import Results from './Results'

function AdvanceResultsPage() {
    const [downloadLink, setDownloadLink] = useState()
    useEffect(() => {
        $.post(
            {
                url: $('#ajax_url').attr('ajax_url'),
                data: {
                    action: 'advance-compare-results-csv',
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
            <Results />
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

export default AdvanceResultsPage
