import { RoleService } from '../services/role'

export const RoleActions = {
    roles,
    add,
    save,
    remove
}

function roles (params = { }) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })
        dispatch({ type: 'ROLES_REQUEST' })

        RoleService.roles(params)
            .then(
                response => {
                    dispatch({ type: 'ROLES_SUCCESS', payload: { data: response.data, meta: response.meta, search: params.search, limit: params.limit ? params.limit : 10, page: params.page ? params.page : 1 } })
                    dispatch({ type: 'FILLING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'ROLES_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}

function add (values) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'ROLE_ADD_REQUEST' })

        RoleService.add(values)
            .then(
                territory => {
                    dispatch({ type: 'ROLE_ADD_SUCCESS', payload: territory })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Роль добавлена.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'ROLE_ADD_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}

function save (id, values) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'ROLE_SAVE_REQUEST' })

        RoleService.save(id, values)
            .then(
                territory => {
                    dispatch({ type: 'ROLE_SAVE_SUCCESS', payload: territory })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Роль изменена.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'ROLE_SAVE_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}

function remove (id) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'ROLE_DELETE_REQUEST' })

        RoleService.remove(id)
            .then(
                () => {
                    dispatch({ type: 'ROLE_DELETE_SUCCESS', payload: id })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Роль удалена.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'ROLE_DELETE_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}
