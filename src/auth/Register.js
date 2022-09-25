import React, { useRef, useState } from 'react'

import {
    TextField,
    MenuItem,
    Button,
    Alert,
    AlertTitle,
    Collapse,
} from '@mui/material'
import LoadingButton from '@mui/lab/LoadingButton'
import Box from '@mui/material/Box'
import IconButton from '@mui/material/IconButton'
import Input from '@mui/material/Input'
import FilledInput from '@mui/material/FilledInput'
import OutlinedInput from '@mui/material/OutlinedInput'
import InputLabel from '@mui/material/InputLabel'
import InputAdornment from '@mui/material/InputAdornment'
import FormHelperText from '@mui/material/FormHelperText'
import FormControl from '@mui/material/FormControl'
import Visibility from '@mui/icons-material/Visibility'
import VisibilityOff from '@mui/icons-material/VisibilityOff'
import PersonAddAltOutlinedIcon from '@mui/icons-material/PersonAddAltOutlined'
import { validate } from 'email-validator'
import * as passwordValidator from 'password-validator'

$ = jQuery
const Register = () => {
    const name = useRef()
    const email = useRef()
    const password = useRef()
    const age = useRef()
    const gender = useRef()
    const connection_type = useRef()

    const [showPassword, setShowPassword] = useState(false)
    const [loading, setLoading] = useState(false)

    const [error, setError] = useState('')
    const [success, setSuccess] = useState(false)

    var schema = new passwordValidator()

    schema
        .is()
        .min(8) // Minimum length 8
        .is()
        .max(100) // Maximum length 100
        .has()
        .not()
        .spaces() // Should not have spaces

    const handleRegister = () => {
        setError('')
        if (name.current.value == '') {
            setError('Name connot be empty')
            return
        }
        if (/\d/.test(name.current.value)) {
            setError('Name connot contain numbers')
            return
        }
        if (email.current.value == '') {
            setError('Email connot be empty')
            return
        }
        if (!validate(email.current.value)) {
            setError('Email is not valid')
            return
        }
        if (password.current.value == '') {
            setError('Password connot be empty')
            return
        }
        if (!schema.validate(password.current.value)) {
            setError(
                'Password must contain at least 8 characters with no spaces'
            )
            return
        }
        if (gender.current.value == undefined) {
            setError('Gender connot be empty')
            return
        }
        if (
            age.current.value == undefined ||
            age.current.value == '' ||
            parseInt(age.current.value) < 6 ||
            parseInt(age.current.value) > 100
        ) {
            setError('Age must be between 6 and 99')
            return
        }
        if (connection_type.current.value == undefined) {
            setError('Connection Type connot be empty')
            return
        }

        setLoading(true)
        $.post(
            {
                url: $('#infos').attr('data-url'),
                data: {
                    action: 'register',
                    name: name.current.value,
                    email: email.current.value,
                    password: password.current.value,
                    age: age.current.value,
                    gender: gender.current.value,
                    connection_type: connection_type.current.value,
                },
            },
            function (res) {
                console.log(res)
                if (res.success) {
                    setSuccess(true)
                    window.location.replace(
                        'https://' +
                            window.location.hostname +
                            ':' +
                            window.location.port
                    )
                } else {
                    setError(res.data.message)
                    setLoading(false)
                }
                // $('.alert').text(jsonResponse.data.message)
            }
        )
    }

    return (
        <div className='container'>
            <div className='vh-100 register'>
                <div className='container-fluid h-custom'>
                    <div className='row d-flex justify-content-center align-items-center h-100'>
                        <div className='col-md-9 col-lg-6 col-xl-5'>
                            <img
                                // src='<?php the_post_thumbnail_url() ?>'
                                src={$('#infos').attr('thum')}
                                className='img-fluid'
                                alt='Sample image'
                            />
                        </div>
                        <div className='col-md-8 col-lg-6 col-xl-4 offset-xl-1'>
                            <form>
                                <div className='divider d-flex align-items-center my-4'>
                                    <p className='text-center fw-bold mx-3 mb-0'>
                                        Sign Up
                                    </p>
                                </div>
                                <TextField
                                    label='Name'
                                    variant='outlined'
                                    className='mb-3'
                                    inputRef={name}
                                    fullWidth
                                    required
                                />
                                <TextField
                                    label='Email'
                                    variant='outlined'
                                    className='mb-3'
                                    type='email'
                                    inputRef={email}
                                    fullWidth
                                    required
                                />

                                <FormControl
                                    variant='outlined'
                                    className='mb-3'
                                    fullWidth
                                    required
                                >
                                    <InputLabel htmlFor='outlined-adornment-password'>
                                        Password
                                    </InputLabel>
                                    <OutlinedInput
                                        type={
                                            showPassword ? 'text' : 'password'
                                        }
                                        inputRef={password}
                                        endAdornment={
                                            <InputAdornment position='end'>
                                                <IconButton
                                                    aria-label='toggle password visibility'
                                                    onClick={() => {
                                                        setShowPassword(true)
                                                    }}
                                                    onMouseDown={() => {
                                                        setShowPassword(false)
                                                    }}
                                                    edge='end'
                                                >
                                                    {showPassword ? (
                                                        <VisibilityOff />
                                                    ) : (
                                                        <Visibility />
                                                    )}
                                                </IconButton>
                                            </InputAdornment>
                                        }
                                        label='Password'
                                    />
                                </FormControl>
                                <div className='row mb-3'>
                                    <div className='col-6'>
                                        <TextField
                                            select
                                            required
                                            label='Gender'
                                            fullWidth
                                            inputRef={gender}
                                            helperText='Please select your Gender'
                                        >
                                            <MenuItem value='male'>
                                                Male
                                            </MenuItem>
                                            <MenuItem value='female'>
                                                Female
                                            </MenuItem>
                                        </TextField>
                                    </div>
                                    <div className='col-6'>
                                        <TextField
                                            id='outlined-select-currency-native'
                                            type='number'
                                            label='Age'
                                            required
                                            fullWidth
                                            inputRef={age}
                                            // SelectProps={{
                                            //     native: true,
                                            // }}
                                            InputProps={{
                                                inputProps: { min: 6, max: 99 },
                                            }}
                                            helperText='Please select your Age'
                                        ></TextField>
                                    </div>
                                </div>
                                <TextField
                                    select
                                    required
                                    label='Connection Type'
                                    fullWidth
                                    inputRef={connection_type}
                                    helperText='Please select your Connection Type'
                                    className='mb-3'
                                >
                                    <MenuItem value='Adsl'>Adsl</MenuItem>
                                    <MenuItem value='Vdsl'>Vdsl</MenuItem>
                                    <MenuItem value='Ftth'>Ftth</MenuItem>
                                    <MenuItem value='Mobile Data'>
                                        Mobile Data
                                    </MenuItem>
                                    <MenuItem value='I Don’t Know/Else'>
                                        I Don’t Know/Else
                                    </MenuItem>
                                </TextField>

                                <Collapse in={error !== ''}>
                                    <Alert
                                        severity='error'
                                        className='mb-3'
                                        onClose={() => {
                                            setError('')
                                        }}
                                    >
                                        <AlertTitle>Error</AlertTitle>
                                        {error}
                                    </Alert>
                                </Collapse>

                                <Collapse in={success}>
                                    <Alert severity='success' className='mb-3'>
                                        <AlertTitle>
                                            Registered successfully
                                        </AlertTitle>
                                        Refreshing...
                                    </Alert>
                                </Collapse>
                                {/*  */}

                                <LoadingButton
                                    variant='contained'
                                    size='large'
                                    fullWidth
                                    loading={loading}
                                    loadingPosition='start'
                                    endIcon={<PersonAddAltOutlinedIcon />}
                                    onClick={handleRegister}
                                >
                                    Register
                                </LoadingButton>

                                <p className='small fw-bold mt-2 pt-1 mb-0'>
                                    Already have an account?
                                    <a
                                        href={$('#infos').attr('login_url')}
                                        className='link-danger'
                                    >
                                        Login
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Register
