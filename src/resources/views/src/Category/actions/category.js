import { CategoryService } from '../services/category'

export const CategoryActions = {
    categories,
    add,
    save,
    remove
}

function categories (params = { }) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'FILLING', payload: true })
        dispatch({ type: 'CATEGORIES_REQUEST' })

        CategoryService.categories(params)
            .then(
                response => {
                    dispatch({ type: 'CATEGORIES_SUCCESS', payload: { data: response.data, meta: response.meta, search: params.search, limit: params.limit ? params.limit : 10, page: params.page ? params.page : 1 } })
                    dispatch({ type: 'FILLING', payload: false })
                    resolve()
                },
                error => {
                    dispatch({ type: 'CATEGORIES_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    dispatch({ type: 'FILLING', payload: false })
                    reject()
                }
            )
    })
}

function add (values) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'CATEGORY_ADD_REQUEST' })

        CategoryService.add(values)
            .then(
                category => {
                    dispatch({ type: 'CATEGORY_ADD_SUCCESS', payload: category })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Категория добавлена.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'CATEGORY_ADD_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}

function save (id, values) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'CATEGORY_SAVE_REQUEST' })

        CategoryService.save(id, values)
            .then(
                category => {
                    dispatch({ type: 'CATEGORY_SAVE_SUCCESS', payload: category })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Категория изменена.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'CATEGORY_SAVE_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}

function remove (id, params = { }) {
    return dispatch => new Promise((resolve, reject) => {
        dispatch({ type: 'CATEGORY_DELETE_REQUEST' })

        CategoryService.remove(id, params)
            .then(
                () => {
                    dispatch({ type: 'CATEGORY_DELETE_SUCCESS', payload: id })
                    dispatch({ type: 'ALERT_SUCCESS', payload: 'Категория удалена.' })
                    resolve()
                },
                error => {
                    dispatch({ type: 'CATEGORY_DELETE_FAILURE' })
                    dispatch({ type: 'ALERT_ERROR', payload: error.message })
                    reject()
                }
            )
    })
}
