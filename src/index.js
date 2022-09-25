// import './frontend.scss';
import React, { useState, useEffect } from 'react'
import ReactDOM from 'react-dom'

import AdvanceComparePage from './AdvanceVideo/AdvanceComparePage'
import AdvanceResultsPage from './AdvanceResults/AdvanceResultsPage'
import AdvanceVideoResultPage from './AdvanceVideoResult/AdvanceVideoResultPage'
import Register from './auth/Register'
import NoAuth from './auth/NoAuth'

if (document.querySelector('#advance-compare'))
    ReactDOM.render(
        <AdvanceComparePage />,
        document.querySelector('#advance-compare')
    )
else if (document.querySelector('#advance-results'))
    ReactDOM.render(
        <AdvanceResultsPage />,
        document.querySelector('#advance-results')
    )
else if (document.querySelector('#advance-video-result'))
    ReactDOM.render(
        <AdvanceVideoResultPage />,
        document.querySelector('#advance-video-result')
    )
else if (document.querySelector('#register')) {
    ReactDOM.render(<Register />, document.querySelector('#register'))
} else if (document.querySelector('#no_auth')) {
    ReactDOM.render(<NoAuth />, document.querySelector('#no_auth'))
}
