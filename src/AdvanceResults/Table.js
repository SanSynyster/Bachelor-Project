import React from 'react'
import { useHistory } from 'react-router-dom'
import { Grid } from 'gridjs-react'
import { h } from 'gridjs'
import 'gridjs/dist/theme/mermaid.css'

function Table(props) {
    const { data } = props

    return (
        <div>
            <Grid
                data={data}
                columns={[
                    {
                        id: 'id',
                        hidden: true,
                    },
                    {
                        id: 'video',
                        name: 'Video',
                    },
                    {
                        id: 'quality',
                        name: 'Quality',
                    },
                    {
                        id: 'user_id',
                        name: 'User ID',
                    },
                    {
                        id: 'user',
                        name: 'User',
                    },
                    {
                        id: 'email',
                        name: 'Email',
                    },
                    {
                        id: 'screen_size',
                        name: 'Screen Size',
                    },
                    {
                        id: 'date',
                        name: 'Date',
                    },
                    {
                        id: 'age',
                        name: 'Age',
                    },
                    {
                        id: 'gender',
                        name: 'Gender',
                    },
                    {
                        id: 'fps',
                        name: 'Fps',
                    },
                    {
                        id: 'device',
                        name: 'Device',
                    },
                    {
                        id: 'bitrate',
                        name: 'Bitrate',
                    },
                    {
                        id: 'browser',
                        name: 'Browser',
                    },
                    {
                        id: 'location',
                        name: 'Location',
                    },
                    {
                        id: 'connection_type',
                        name: 'Connection Type',
                    },

                    {
                        name: 'Actions',
                        formatter: (cell, row) => {
                            return h(
                                'a',
                                {
                                    className: 'btn btn-primary',
                                    style: { width: '120px' },
                                    href:
                                        '/advance-video-result?video_id=' +
                                        row.cells[0].data,
                                },
                                'Show results'
                            )
                        },
                    },
                ]}
                search={true}
                pagination={{
                    enabled: true,
                    limit: 12,
                }}
                sort
                language={{
                    search: {
                        placeholder: '🔍 Search...',
                    },
                }}
            />
        </div>
    )
}

export default Table
