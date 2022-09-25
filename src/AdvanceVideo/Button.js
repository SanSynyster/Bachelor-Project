import React from 'react'

function Button(props) {
    const { children, onClick, className, disabled } = props

    return (
        <button
            className={`btn btn-primary ${className}`}
            // style={{ width: '100%' }}
            onClick={onClick}
            disabled={disabled}
        >
            {children}
        </button>
    )
}

export default Button
