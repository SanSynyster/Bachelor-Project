import React, { useRef, useState, useEffect } from 'react'
import Plyr from 'plyr-react'

import 'plyr-react/dist/plyr.css'

function Video(props) {
    const { src, ref } = props

    // useEffect(() => {
    //     // Access the internal plyr instance
    //     console.log(ref.current.plyr)
    // })

    return (
        <div
            className='p-3'
            style={{
                backgroundColor: 'gray',
            }}
        >
            <div>
                <Plyr
                    source={{
                        type: 'video',
                        sources: [
                            {
                                src,
                                type: 'video/mp4',
                                size: 720,
                            },
                        ],
                    }}
                    options={{
                        controls: [
                            'play-large',
                            // 'play',
                            'progress',
                            'current-time',
                            'volume',
                            'fullscreen',
                        ],
                    }}
                    ref={ref}
                />
            </div>
        </div>
    )
}

export default Video
