import { RoleService } from '../services/role'

export const RoleActions = {
    roles
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
