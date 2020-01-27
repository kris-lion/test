import { UnitService } from '../../services/Unit/unit'

export const UnitActions = {
    units
}

function units () {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })
        dispatch({ type: 'UNITS_REQUEST' })

        UnitService.types()
            .then(
                units => {
                    dispatch({ type: 'UNITS_SUCCESS', payload: units })
                    dispatch({ type: 'FILLING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'UNITS_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}
