import { UserService } from '../services/user'

export const UserActions = {
    users,
    add,
    save,
    remove
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

function add (values) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'USER_ADD_REQUEST' })

        UserService.add(values)
            .then(
                territory => {
                    dispatch({ type: 'USER_ADD_SUCCESS', payload: territory })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Пользователь добавлен.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'USER_ADD_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}

function save (id, values) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'USER_SAVE_REQUEST' })

        UserService.save(id, values)
            .then(
                territory => {
                    dispatch({ type: 'USER_SAVE_SUCCESS', payload: territory })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Пользователь изменен.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'USER_SAVE_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}

function remove (id) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'USER_DELETE_REQUEST' })

        UserService.remove(id)
            .then(
                () => {
                    dispatch({ type: 'USER_DELETE_SUCCESS', payload: id })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Пользователь удален.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'USER_DELETE_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}
