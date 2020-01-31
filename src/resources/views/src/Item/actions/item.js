import { ItemService } from '../services/item'

export const ItemActions = {
    items,
    count,
    add,
    save,
    remove
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

function count (params = { }) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })

        ItemService.count(params)
            .then(
                response => {
                    dispatch({ type: 'FILLING', payload: false })
                    resolve(response.count)
                },
                error => {
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}

function add (values) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'ITEM_ADD_REQUEST' })

        ItemService.add(values)
            .then(
                item => {
                    dispatch({ type: 'ITEM_ADD_SUCCESS', payload: item })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Эталон добавлен.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'ITEM_ADD_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}

function save (id, values) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'ITEM_SAVE_REQUEST' })

        ItemService.save(id, values)
            .then(
                item => {
                    dispatch({ type: 'ITEM_SAVE_SUCCESS', payload: item })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Эталон изменён.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'ITEM_SAVE_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}

function remove (id) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'ITEM_DELETE_REQUEST' })

        ItemService.remove(id)
            .then(
                () => {
                    dispatch({ type: 'ITEM_DELETE_SUCCESS', payload: id })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Эталон удалён.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'ITEM_DELETE_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}
