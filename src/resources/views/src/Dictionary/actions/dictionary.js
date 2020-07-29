import { DictionaryService } from '../services/dictionary'

export const DictionaryActions = {
    generics
}

function generics (params = { }) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })
        dispatch({ type: 'DICTIONARY_GENERICS_REQUEST' })

        DictionaryService.generics(params)
            .then(
                generics => {
                    dispatch({ type: 'DICTIONARY_GENERICS_SUCCESS', payload: generics })
                    dispatch({ type: 'FILLING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'DICTIONARY_GENERICS_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}
