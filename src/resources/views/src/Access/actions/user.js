import { UserService } from '../services/user'

export const UserActions = {
    users
}

function users (params = { }) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })
        dispatch({ type: 'USERS_REQUEST' })

        UserService.users(params)
            .then(
                response => {
                    dispatch({ type: 'USERS_SUCCESS', payload: { data: response.data, meta: response.meta, search: params.search, limit: params.limit ? params.limit : 10, page: params.page ? params.page : 1 } })
                    dispatch({ type: 'FILLING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'USERS_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}
