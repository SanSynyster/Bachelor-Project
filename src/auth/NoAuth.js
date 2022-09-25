import React from 'react'

import { Button, Alert } from '@mui/material'
import LockOpenTwoToneIcon from '@mui/icons-material/LockOpenTwoTone'
import PersonAddAltTwoToneIcon from '@mui/icons-material/PersonAddAltTwoTone'

$ = jQuery
const NoAuth = () => {
    return (
        <div className='container px-2' style={{ height: '100vh' }}>
            <div className='row h-100  p-1'>
                <div className='col'></div>
                <div className='d-flex justify-content-center align-items-center h-100 flex-column col-12 col-lg-7 col-xl-6'>
                    <div className='p-2'>
                        <img
                            src={$('#infos').attr('logo')}
                            alt=''
                            width={350}
                        />
                    </div>
                    <div className='row w-100 mt-3'>
                        <div className='col-6'>
                            <Button
                                variant='contained'
                                size='large'
                                fullWidth
                                endIcon={<LockOpenTwoToneIcon />}
                                href={$('#infos').attr('login_url')}
                                // onClick={handleRegister}
                            >
                                Login
                            </Button>
                        </div>
                        <div className='col-6'>
                            <Button
                                variant='contained'
                                size='large'
                                fullWidth
                                endIcon={<PersonAddAltTwoToneIcon />}
                                href={$('#infos').attr('register_url')}
                                // onClick={handleRegister}
                            >
                                Register
                            </Button>
                        </div>
                    </div>
                    <div className='p-2 w-100'>
                        <Alert severity='info' className='w-100 mt-4' fullWidth>
                            <div
                                style={{ fontSize: 20, direction: 'rtl' }}
                                dangerouslySetInnerHTML={{
                                    __html: $('#infos').attr('text'),
                                }}
                            ></div>
                        </Alert>
                    </div>
                </div>
                <div className='col'></div>
            </div>
        </div>
    )
}

export default NoAuth
