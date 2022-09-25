import React, { useState, useEffect } from 'react'
import Table from './Table'

$ = jQuery

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&')
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url)
    if (!results) return null
    if (!results[2]) return ''
    return decodeURIComponent(results[2].replace(/\+/g, ' '))
}

function Results() {
    const [results, setResults] = useState([])

    useEffect(() => {
        $.post(
            {
                url: $('#ajax_url').attr('ajax_url'),
                data: {
                    action: 'advance-compare-results',
                    foren: getParameterByName('foren'),
                },
            },
            function (res) {
                console.log(res)
                setResults(res.data.results)
            }
        )
    }, [])

    return (
        <div>{results && results.length > 0 && <Table data={results} />}</div>
    )
}

export default Results
