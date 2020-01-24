import { TypeService } from '../../services/Attribute/type'

export const TypeActions = {
    types
}

function types () {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })
        dispatch({ type: 'CATEGORY_ATTRIBUTE_TYPES_REQUEST' })

        TypeService.types()
            .then(
                types => {
                    dispatch({ type: 'CATEGORY_ATTRIBUTE_TYPES_SUCCESS', payload: types })
                    dispatch({ type: 'FILLING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'CATEGORY_ATTRIBUTE_TYPES_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}
