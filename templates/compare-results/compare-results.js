$.get(
    {
        url: $('#infos').attr('data-url'),
        data: {
            action: 'get-compare-results',
        },
    },
    function (jsonResponse) {
        if (jsonResponse.success) {
            // console.log(jsonResponse.data)
            $('#wrapper').Grid({
                columns: [
                    {
                        id: 'video',
                        name: 'Video',
                        // width: "100px",
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
                        id: 'value',
                        name: 'Value',
                        // width: "120px",
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
                        id: 'date',
                        name: 'Date',
                    },
                    {
                        id: 'connection_type',
                        name: 'Connection Type',
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
            action: 'get-compare-results-csv',
        },
    },
    function (jsonResponse) {
        $('.download-excel').attr('href', jsonResponse.data.url)
        $('.download-excel').slideDown()
    }
)
