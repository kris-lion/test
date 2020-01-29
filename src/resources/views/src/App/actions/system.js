import { SystemService } from '../services/system'

export const SystemActions = {
    categories
}

function categories () {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })
        dispatch({ type: 'SYSTEM_CATEGORIES_REQUEST' })

        SystemService.categories()
            .then(
                categories => {
                    dispatch({ type: 'SYSTEM_CATEGORIES_SUCCESS', payload: categories })
                    dispatch({ type: 'FILLING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'SYSTEM_CATEGORIES_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}
