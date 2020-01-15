import { history } from '../../App/helpers/history'
import { AccountService } from '../services/account'

export const AccountActions = {
    account,
    clear
}

function account() {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'LOADING', payload: true })
        dispatch({ type: 'ACCOUNT_REQUEST' })

        AccountService.account()
            .then(
                account => {
                    dispatch({ type: 'ACCOUNT', payload: account })
                    dispatch({ type: 'LOADING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'ACCOUNT_FAILURE' })
                    dispatch({ type: 'LOADING', payload: false })
                    history.push('/logout')
                    reject(error.error)
                }
            )
    })
}

function clear() {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'LOADING', payload: true })

        localStorage.removeItem('account')
        localStorage.removeItem('token')

        dispatch({ type: 'ACCOUNT' })
        dispatch({ type: 'LOADING', payload: false })
    })
}
