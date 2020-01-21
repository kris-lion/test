import { CategoryService } from '../services/category'

export const CategoryActions = {
    categories
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
