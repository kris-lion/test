import { ItemService } from '../services/item'

export const ItemActions = {
    items
}

function items (params = { }) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })
        dispatch({ type: 'ITEMS_REQUEST' })

        ItemService.items(params)
            .then(
                response => {
                    dispatch({ type: 'ITEMS_SUCCESS', payload: { data: response.data, meta: response.meta, category: params.category, limit: params.limit ? params.limit : 10, page: params.page ? params.page : 1 } })
                    dispatch({ type: 'FILLING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'ITEMS_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}
