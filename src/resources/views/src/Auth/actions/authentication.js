import { history } from '../../App/helpers/history'
import { AuthService } from '../services/auth'

export const AuthActions = {
    login,
    logout
}

function login(values) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'AUTH_LOGIN_REQUEST' })

        AuthService.login(values)
            .then(
                account => {
                    dispatch({ type: 'AUTH_LOGIN_SUCCESS' })
                    dispatch({ type: 'ACCOUNT', payload: account })

                    const redirect = localStorage.getItem('redirect')

                    redirect ? history.push(redirect) : history.push('/')
                },
                error => {
                    dispatch({ type: 'AUTH_LOGIN_FAILURE' })
                    if (error.message) {
                        dispatch({type: 'ALERT_ERROR', payload: error.message})
                    }
                    reject(error.errors)
                }
            )
    })
}

function logout() {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'LOADING', payload: true })
        dispatch({ type: 'AUTH_LOGOUT_REQUEST' })

        AuthService.logout()

        localStorage.removeItem('account')
        localStorage.removeItem('token')

        dispatch({ type: 'AUTH_LOGOUT_SUCCESS' })
        dispatch({ type: 'ACCOUNT' })
        dispatch({ type: 'LOADING', payload: false })
        history.push('/')
    })
}
