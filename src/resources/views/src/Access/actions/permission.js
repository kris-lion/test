import { PermissionService } from '../services/permission'

export const PermissionActions = {
    permissions
}

function permissions () {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })
        dispatch({ type: 'PERMISSIONS_REQUEST' })

        PermissionService.permissions()
            .then(
                profiles => {
                    dispatch({ type: 'PERMISSIONS_SUCCESS', payload: profiles })
                    dispatch({ type: 'FILLING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'PERMISSIONS_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}
