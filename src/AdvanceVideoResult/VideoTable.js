import React from 'react'
import { useHistory } from 'react-router-dom'
import { Grid } from 'gridjs-react'
import { h } from 'gridjs'
import 'gridjs/dist/theme/mermaid.css'

function VideoTable(props) {
    const { data } = props

    return (
        <div>
            <Grid
                data={data}
                columns={[
                    {
                        id: 'quality',
                        name: 'Quality',
                    },
                    {
                        id: 'fps',
                        name: 'Fps',
                    },
                    {
                        id: 'bitrate',
                        name: 'Bitrate',
                    },
                    {
                        id: 'answer_count',
                        name: 'Count',
                    },
                ]}
                search={true}
                sort
                pagination={{
                    enabled: true,
                    limit: 12,
                }}
                language={{
                    search: {
                        placeholder: '🔍 Search...',
                    },
                }}
            />
        </div>
    )
}

export default VideoTable
