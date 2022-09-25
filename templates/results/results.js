$.get(
    {
        url: $('#infos').attr('data-url'),
        data: {
            action: 'get-results',
        },
    },
    function (jsonResponse) {
        if (jsonResponse.success) {
            $('#wrapper').Grid({
                columns: [
                    {
                        id: 'video',
                        name: 'Video',
                        width: '100px',
                    },
                    {
                        id: 'quality',
                        name: 'Quality',
                    },
                    {
                        id: 'fps',
                        name: 'FPS',
                    },
                    {
                        id: 'bitrate',
                        name: 'Bitrate',
                    },
                    {
                        id: 'user',
                        name: 'User',
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
                        id: 'email',
                        name: 'Email',
                    },
                    {
                        id: 'rate',
                        name: 'Rate',
                        width: '100px',
                    },
                    {
                        id: 'screen_size',
                        name: 'Screen Size',
                    },
                    {
                        id: 'device',
                        name: 'Device',
                    },
                    {
                        id: 'custom',
                        name: 'Custom',
                    },
                    {
                        id: 'date',
                        name: 'Date',
                    },
                ],
                pagination: {
                    limit: 8,
                },
                data: jsonResponse.data,
                search: true,
                resizable: true,
                fixedHeader: true,
                // width: "1000px",
                language: {
                    search: {
                        placeholder: '🔍 Search...',
                    },
                },
                sort: true,
            })
        } else {
        }
    }
)

$.get(
    {
        url: $('#infos').attr('data-url'),
        data: {
            action: 'get-results-csv',
        },
    },
    function (jsonResponse) {
        $('.download-excel').attr('href', jsonResponse.data.url)
        $('.download-excel').slideDown()
    }
)
